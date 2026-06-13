<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Cabang;
use App\Models\DistribusiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistribusiBarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = DistribusiBarang::with(['barang', 'cabang'])
            ->orderBy('tanggal_distribusi', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('barang', function ($qb) use ($search) {
                    $qb->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('cabang', function ($qc) use ($search) {
                    $qc->where('kode_cabang', 'like', "%{$search}%")
                        ->orWhere('nama_cabang', 'like', "%{$search}%")
                        ->orWhere('kota', 'like', "%{$search}%");
                })
                ->orWhereDate('tanggal_distribusi', $search);
            });
        }

        $distribusi = $query->paginate(10)->withQueryString();

        return view('pages.warehouse.outbound.index', compact('distribusi'));
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
            'jumlah' => 'required|integer|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $barang = Barang::where('id', $data['barang_id'])->lockForUpdate()->firstOrFail();

                $stokSaatIni = (int) ($barang->stok ?? 0);
                $jumlah = (int) $data['jumlah'];

                if ($stokSaatIni < $jumlah) {
                    throw new \RuntimeException('Stok tidak mencukupi untuk pengeluaran barang.');
                }

                DistribusiBarang::create($data);

                $barang->stok = $stokSaatIni - $jumlah;
                $barang->save();
            });

            return redirect()->route('warehouse.outbound.index')->with('success', 'Distribusi barang berhasil disimpan');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menyimpan distribusi');
        }
    }

    public function edit($id)
    {
        $distribusi = DistribusiBarang::with(['barang', 'cabang'])->findOrFail($id);
        $barangs = Barang::orderBy('nama_barang')->get();
        $cabangs = Cabang::orderBy('nama_cabang')->get();

        return view('pages.warehouse.outbound.edit', compact('distribusi', 'barangs', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        $distribusi = DistribusiBarang::findOrFail($id);

        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'cabang_id' => 'required|exists:cabang,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_distribusi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($data, $distribusi) {
                $oldBarangId = $distribusi->barang_id;
                $oldJumlah = (int) ($distribusi->jumlah ?? 0);

                $newBarangId = (int) $data['barang_id'];
                $newJumlah = (int) $data['jumlah'];

                if ($oldBarangId !== $newBarangId) {
                    // revert old
                    $oldBarang = Barang::where('id', $oldBarangId)->lockForUpdate()->firstOrFail();
                    $oldBarang->stok = (int) ($oldBarang->stok ?? 0) + $oldJumlah;
                    $oldBarang->save();

                    // check new
                    $newBarang = Barang::where('id', $newBarangId)->lockForUpdate()->firstOrFail();
                    $stokSaatIni = (int) ($newBarang->stok ?? 0);
                    if ($stokSaatIni < $newJumlah) {
                        throw new \RuntimeException('Stok tidak mencukupi untuk pengeluaran barang.');
                    }

                    $newBarang->stok = $stokSaatIni - $newJumlah;
                    $newBarang->save();
                } else {
                    $barang = Barang::where('id', $newBarangId)->lockForUpdate()->firstOrFail();

                    $stokSaatIni = (int) ($barang->stok ?? 0);
                    // stok saat ini sudah dikurangi oldJumlah, jadi kita hanya apply selisih
                    $selisih = $newJumlah - $oldJumlah;
                    $stokBaru = $stokSaatIni - $selisih;

                    if ($stokBaru < 0) {
                        throw new \RuntimeException('Stok tidak mencukupi untuk pengeluaran barang.');
                    }

                    $barang->stok = $stokBaru;
                    $barang->save();
                }

                $distribusi->update($data);
            });

            return redirect()->route('warehouse.outbound.index')->with('success', 'Distribusi barang berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat memperbarui distribusi');
        }
    }

    public function destroy($id)
    {
        $distribusi = DistribusiBarang::findOrFail($id);

        try {
            DB::transaction(function () use ($distribusi) {
                $barang = Barang::where('id', $distribusi->barang_id)->lockForUpdate()->firstOrFail();

                $jumlah = (int) ($distribusi->jumlah ?? 0);
                // saat delete outbound, stok harus dikembalikan
                $barang->stok = (int) ($barang->stok ?? 0) + $jumlah;
                $barang->save();

                $distribusi->delete();
            });

            return redirect()->route('warehouse.outbound.index')->with('success', 'Distribusi barang berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menghapus distribusi');
        }
    }
}

