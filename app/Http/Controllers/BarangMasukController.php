<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomingGoodsRequest;
use App\Http\Requests\UpdateIncomingGoodsRequest;
use App\Models\Barang;
use App\Models\IncomingGoods;
use App\Models\IncomingGoodsDetail;
use App\Models\RackLocation;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;



class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = IncomingGoods::with(['details.item']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receiving_code', 'like', "%{$search}%")
                    ->orWhere('container_number', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%")
                    ->orWhereHas('details.item', function ($q) use ($search) {
                        $q->where('kode_barang', 'like', "%{$search}%")
                            ->orWhere('nama_barang', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('receiving_date', $bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('receiving_date', $tahun);
        }

        // Sortable columns
        $sortable = ['receiving_code', 'receiving_date', 'supplier'];
        $sort = $request->get('sort', 'receiving_date');
        $direction = $request->get('direction', 'desc');

        // Validate sort column and direction
        if (!in_array($sort, $sortable)) {
            $sort = 'receiving_date';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // Apply sorting
        $query->orderBy($sort, $direction);

        $incomingGoods = $query->paginate(10)->withQueryString();

        return view('barang-masuk.index', compact('incomingGoods', 'sort', 'direction'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $rackLocations = RackLocation::orderBy('code')->get();

        return view('barang-masuk.create', compact('barangs', 'rackLocations'));
    }

    public function store(StoreIncomingGoodsRequest $request)
    {
        $validated = $request->validated();





        $userId = auth()->id();
        if (! $userId) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['created_by' => 'Anda harus login untuk menyimpan barang masuk.']);
        }

        try {
            DB::transaction(function () use ($validated, $userId) {
                $incomingGoods = IncomingGoods::create([




                    'receiving_code' => IncomingGoods::generateReceivingCode(),
                    'container_number' => $validated['container_number'] ?? null,
                    'receiving_date' => $validated['receiving_date'],
                    'supplier_id' => null,
                    'supplier' => $validated['supplier'] ?? null,
                    'delivery_order_number' => $validated['delivery_order_number'] ?? null,
                    'description' => $validated['description'] ?? null,
                    'created_by' => $userId,
                ]);

                // Debug sementara: hentikan eksekusi agar tidak mengganggu submit
                // Log::info('BarangMasuk header created', ['receiving_code' => $incomingGoods->receiving_code]);

                foreach ($validated['items'] as $item) {
                    IncomingGoodsDetail::create([
                        'incoming_goods_id' => $incomingGoods->id,
                        'item_id' => $item['item_id'],
                        'quantity_received' => $item['quantity_received'],
                        'rack_location_id' => $item['rack_location_id'],
                    ]);

                    // dd debug removed


                    $barang = Barang::findOrFail($item['item_id']);
                    $barang->stok = ($barang->stok ?? 0) + (int) $item['quantity_received'];

                    $rackLocation = RackLocation::find($item['rack_location_id']);
                    if ($rackLocation) {
                        $barang->lokasi_rak = $rackLocation->code;
                    }

                    $barang->save();
                    // dd debug removed

                }
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Transaksi barang masuk berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('BarangMasukController@store failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi barang masuk.');
        }
    }

    public function edit($id)
    {
        $incomingGoods = IncomingGoods::with(['details'])->findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        $rackLocations = RackLocation::orderBy('code')->get();

        return view('barang-masuk.edit', compact('incomingGoods', 'barangs', 'rackLocations'));
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
                    'container_number' => $validated['container_number'] ?? null,
                    'receiving_date' => $validated['receiving_date'],
                    'supplier_id' => null,
                    'supplier' => $validated['supplier'] ?? null,
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

    public function exportPdf(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = IncomingGoods::with(['details.item'])
            ->orderBy('receiving_date', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('receiving_code', 'like', "%{$search}%")
                    ->orWhere('container_number', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%")
                    ->orWhereHas('details.item', function ($q) use ($search) {
                        $q->where('kode_barang', 'like', "%{$search}%")
                            ->orWhere('nama_barang', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('receiving_date', $bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('receiving_date', $tahun);
        }

        $incomingGoods = $query->get();

        $pdf = Pdf::loadView('pdfs.barang-masuk', [
            'incomingGoods' => $incomingGoods,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'printDate' => now(),
            'totalData' => count($incomingGoods),
        ]);

        return $pdf->download('Laporan-Barang-Masuk-' . now()->format('Y-m-d-His') . '.pdf');
    }
}
