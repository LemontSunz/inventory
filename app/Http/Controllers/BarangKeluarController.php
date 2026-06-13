<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = BarangKeluar::with(['barang', 'cabang'])
            ->orderBy('tanggal_keluar', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($qb) use ($search) {
                    $qb->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('cabang', function ($qc) use ($search) {
                    $qc->where('nama_cabang', 'like', "%{$search}%");
                })
                ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $barangKeluars = $query->paginate(10)->withQueryString();

        return view('pages.warehouse.outbound.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        $cabangs = Cabang::orderBy('nama_cabang')->get();

        return view('pages.warehouse.outbound.create', compact('barangs', 'cabangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'cabang_id' => 'required|exists:cabang,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $barang = Barang::where('id', $data['barang_id'])->lockForUpdate()->firstOrFail();

                $stokSaatIni = (int) ($barang->stok ?? 0);
                $jumlah = (int) $data['jumlah_keluar'];

                if ($stokSaatIni < $jumlah) {
                    throw new \RuntimeException('Stok barang tidak mencukupi.');
                }

                BarangKeluar::create($data);

                $barang->stok = $stokSaatIni - $jumlah;
                $barang->save();
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil disimpan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menyimpan Barang Keluar');
        }
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'cabang'])->findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        $cabangs = Cabang::orderBy('nama_cabang')->get();

        return view('pages.warehouse.outbound.edit', compact('barangKeluar', 'barangs', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'cabang_id' => 'required|exists:cabang,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $barangKeluar) {
                $oldBarangId = (int) $barangKeluar->barang_id;
                $oldJumlah = (int) ($barangKeluar->jumlah_keluar ?? 0);

                $newBarangId = (int) $data['barang_id'];
                $newJumlah = (int) $data['jumlah_keluar'];

                if ($oldBarangId !== $newBarangId) {
                    $oldBarang = Barang::where('id', $oldBarangId)->lockForUpdate()->firstOrFail();
                    $oldBarang->stok = (int) ($oldBarang->stok ?? 0) + $oldJumlah;
                    $oldBarang->save();

                    $newBarang = Barang::where('id', $newBarangId)->lockForUpdate()->firstOrFail();
                    $stokSaatIni = (int) ($newBarang->stok ?? 0);

                    if ($stokSaatIni < $newJumlah) {
                        throw new \RuntimeException('Stok barang tidak mencukupi untuk melakukan update.');
                    }

                    $newBarang->stok = $stokSaatIni - $newJumlah;
                    $newBarang->save();
                } else {
                    $barang = Barang::where('id', $newBarangId)->lockForUpdate()->firstOrFail();

                    $stokSaatIni = (int) ($barang->stok ?? 0);
                    // saat ini stok sudah dikurangi oldJumlah
                    $selisih = $newJumlah - $oldJumlah;

                    if ($selisih > 0) {
                        // butuh tambahan stok untuk menambah pengeluaran
                        if ($stokSaatIni < $selisih) {
                            throw new \RuntimeException('Stok barang tidak mencukupi untuk melakukan update.');
                        }
                        $barang->stok = $stokSaatIni - $selisih;
                    } else {
                        // mengurangi jumlah keluar -> kembalikan selisih
                        $barang->stok = $stokSaatIni + abs($selisih);
                    }

                    $barang->save();
                }

                $barangKeluar->update($data);
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat memperbarui Barang Keluar');
        }
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        try {
            DB::transaction(function () use ($barangKeluar) {
                $barang = Barang::where('id', $barangKeluar->barang_id)->lockForUpdate()->firstOrFail();

                $jumlah = (int) ($barangKeluar->jumlah_keluar ?? 0);
                $barang->stok = (int) ($barang->stok ?? 0) + $jumlah;
                $barang->save();

                $barangKeluar->delete();
            });

            return redirect()->route('barang-keluar.index')->with('success', 'Barang Keluar berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menghapus Barang Keluar');
        }
    }
}

