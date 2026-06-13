<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = BarangMasuk::with('barang')->orderBy('tanggal_masuk', 'desc');

        if ($search) {
            $query->where('supplier', 'like', "%{$search}%")
                  ->orWhereHas('barang', function ($q) use ($search) {
                      $q->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                  });
        }

        $barangMasuks = $query->paginate(10)->withQueryString();

        return view('barang-masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang-masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'supplier' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $barangMasuk = BarangMasuk::create($data);

                // Update stock
                $barang = Barang::findOrFail($data['barang_id']);
                $barang->stok = ($barang->stok ?? 0) + $data['qty_masuk'];
                $barang->save();
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan pada data yang dimasukkan');
        }
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang-masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_masuk' => 'required|date',
            'qty_masuk' => 'required|integer|min:1',
            'supplier' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $barangMasuk) {
                // adjust stock
                $oldQty = $barangMasuk->qty_masuk;

                // If barang_id changed, revert old barang stok and add to new barang
                if ($barangMasuk->barang_id != $data['barang_id']) {
                    $oldBarang = Barang::find($barangMasuk->barang_id);
                    if ($oldBarang) {
                        $oldBarang->stok = max(0, ($oldBarang->stok ?? 0) - $oldQty);
                        $oldBarang->save();
                    }

                    $newBarang = Barang::findOrFail($data['barang_id']);
                    $newBarang->stok = ($newBarang->stok ?? 0) + $data['qty_masuk'];
                    $newBarang->save();
                } else {
                    $barang = Barang::findOrFail($data['barang_id']);
                    $diff = $data['qty_masuk'] - $oldQty;
                    $barang->stok = max(0, ($barang->stok ?? 0) + $diff);
                    $barang->save();
                }

                $barangMasuk->update($data);
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan pada data yang dimasukkan');
        }
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        try {
            DB::transaction(function () use ($barangMasuk) {
                $barang = Barang::find($barangMasuk->barang_id);
                if ($barang) {
                    $barang->stok = max(0, ($barang->stok ?? 0) - $barangMasuk->qty_masuk);
                    $barang->save();
                }

                $barangMasuk->delete();
            });

            return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan pada data yang dimasukkan');
        }
    }
}
