<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomingGoodsRequest;
use App\Http\Requests\UpdateIncomingGoodsRequest;
use App\Models\Barang;
use App\Models\IncomingGoods;
use App\Models\IncomingGoodsDetail;
use App\Models\RackLocation;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = IncomingGoods::with(['supplier', 'details.item'])
            ->orderBy('receiving_date', 'desc');

        if ($search) {
            $query->where('receiving_code', 'like', "%{$search}%")
                ->orWhere('container_number', 'like', "%{$search}%")
                ->orWhereHas('supplier', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('details.item', function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                });
        }

        $incomingGoods = $query->paginate(10)->withQueryString();

        return view('barang-masuk.index', compact('incomingGoods'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $rackLocations = RackLocation::orderBy('code')->get();

        return view('barang-masuk.create', compact('barangs', 'suppliers', 'rackLocations'));
    }

    public function store(StoreIncomingGoodsRequest $request)
    {
        $validated = $request->validated();
        $userId = $request->user()->id;

        try {
            DB::transaction(function () use ($validated, $userId) {
                $incomingGoods = IncomingGoods::create([
                    'receiving_code' => $validated['receiving_code'],
                    'container_number' => $validated['container_number'] ?? null,
                    'receiving_date' => $validated['receiving_date'],
                    'supplier_id' => $validated['supplier_id'],
                    'delivery_order_number' => $validated['delivery_order_number'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'created_by' => $userId,
                ]);

                foreach ($validated['items'] as $item) {
                    IncomingGoodsDetail::create([
                        'incoming_goods_id' => $incomingGoods->id,
                        'item_id' => $item['item_id'],
                        'quantity_received' => $item['quantity_received'],
                        'rack_location_id' => $item['rack_location_id'],
                    ]);

                    $barang = Barang::findOrFail($item['item_id']);
                    $barang->stok = ($barang->stok ?? 0) + (int) $item['quantity_received'];

                    $rackLocation = RackLocation::find($item['rack_location_id']);
                    if ($rackLocation) {
                        $barang->lokasi_rak = $rackLocation->code;
                    }

                    $barang->save();
                }
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Transaksi barang masuk berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('BarangMasukController@store failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $validated,
            ]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi barang masuk.');
        }
    }

    public function edit($id)
    {
        $incomingGoods = IncomingGoods::with(['details'])->findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $rackLocations = RackLocation::orderBy('code')->get();

        return view('barang-masuk.edit', compact('incomingGoods', 'barangs', 'suppliers', 'rackLocations'));
    }

    public function update(UpdateIncomingGoodsRequest $request, $id)
    {
        $incomingGoods = IncomingGoods::with('details')->findOrFail($id);
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($incomingGoods, $validated) {
                foreach ($incomingGoods->details as $detail) {
                    $barang = Barang::find($detail->item_id);
                    if ($barang) {
                        $barang->stok = max(0, ($barang->stok ?? 0) - $detail->quantity_received);
                        $barang->save();
                    }
                }

                $incomingGoods->update([
                    'receiving_code' => $validated['receiving_code'],
                    'container_number' => $validated['container_number'] ?? null,
                    'receiving_date' => $validated['receiving_date'],
                    'supplier_id' => $validated['supplier_id'],
                    'delivery_order_number' => $validated['delivery_order_number'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]);

                $incomingGoods->details()->delete();

                foreach ($validated['items'] as $item) {
                    IncomingGoodsDetail::create([
                        'incoming_goods_id' => $incomingGoods->id,
                        'item_id' => $item['item_id'],
                        'quantity_received' => $item['quantity_received'],
                        'rack_location_id' => $item['rack_location_id'],
                    ]);

                    $barang = Barang::findOrFail($item['item_id']);
                    $barang->stok = ($barang->stok ?? 0) + (int) $item['quantity_received'];

                    $rackLocation = RackLocation::find($item['rack_location_id']);
                    if ($rackLocation) {
                        $barang->lokasi_rak = $rackLocation->code;
                    }

                    $barang->save();
                }
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Transaksi barang masuk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('BarangMasukController@update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $validated,
                'incoming_goods_id' => $incomingGoods->id,
            ]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui transaksi barang masuk.');
        }
    }

    public function destroy($id)
    {
        $incomingGoods = IncomingGoods::with('details')->findOrFail($id);

        try {
            DB::transaction(function () use ($incomingGoods) {
                foreach ($incomingGoods->details as $detail) {
                    $barang = Barang::find($detail->item_id);
                    if ($barang) {
                        $barang->stok = max(0, ($barang->stok ?? 0) - $detail->quantity_received);
                        $barang->save();
                    }
                }

                $incomingGoods->delete();
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Transaksi barang masuk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('BarangMasukController@destroy failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'incoming_goods_id' => $incomingGoods->id,
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus transaksi barang masuk.');
        }
    }
}
