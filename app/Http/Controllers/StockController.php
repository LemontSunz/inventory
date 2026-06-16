<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class StockController extends Controller
{
    /**
     * Tampilkan halaman laporan stok barang.
     * - Menggunakan withSum() agar agregasi dijalankan oleh database (hindari N+1)
     * - Filter pencarian dan rentang tanggal diterapkan pada relasi barang_masuks dan barang_keluars
     */
    public function index(Request $request)
    {
        // Validasi input request
        $data = $request->validate([
            'search' => 'nullable|string|max:255',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
        ]);

        $search = $data['search'] ?? null;
        $tanggalAwal = $data['tanggal_awal'] ?? null;
        $tanggalAkhir = $data['tanggal_akhir'] ?? null;

        // Query utama: ambil barang beserta total masuk/keluar sesuai filter tanggal
        $query = Barang::query()
            ->withSum([
                // total barang masuk (qty_masuk) dengan filter tanggal jika ada
                'barangMasuks as total_masuk' => $this->dateRangeClosure($tanggalAwal, $tanggalAkhir, 'tanggal_masuk'),
            ], 'qty_masuk')
            ->withSum([
                // total barang keluar (jumlah_keluar) dengan filter tanggal jika ada
                'barangKeluars as total_keluar' => $this->dateRangeClosure($tanggalAwal, $tanggalAkhir, 'tanggal_keluar'),
            ], 'jumlah_keluar');

        // Pencarian berdasarkan kode_barang atau nama_barang
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        // Pagination: 10 per halaman, tetap menjaga query string
        $laporans = $query->orderBy('kode_barang')->paginate(10)->withQueryString();

        // Hitung stok saat ini dan status untuk setiap item pada halaman (operasi ringan, tanpa query tambahan)
        $laporans->getCollection()->transform(function ($item) {
            $totalMasuk = (int) ($item->total_masuk ?? 0);
            $totalKeluar = (int) ($item->total_keluar ?? 0);

            $stokSaatIni = $totalMasuk - $totalKeluar;

            $item->total_masuk = $totalMasuk;
            $item->total_keluar = $totalKeluar;
            $item->stok_saat_ini = $stokSaatIni;
            $item->status_stok = $this->determineStatus($stokSaatIni);

            return $item;
        });

        // Ringkasan dashboard: menghitung berdasarkan keseluruhan dataset (memperhitungkan filter tanggal dan pencarian)
        $summaryQuery = Barang::query()
            ->withSum([
                'barangMasuks as total_masuk' => $this->dateRangeClosure($tanggalAwal, $tanggalAkhir, 'tanggal_masuk'),
            ], 'qty_masuk')
            ->withSum([
                'barangKeluars as total_keluar' => $this->dateRangeClosure($tanggalAwal, $tanggalAkhir, 'tanggal_keluar'),
            ], 'jumlah_keluar');

        if ($search) {
            $summaryQuery->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        $all = $summaryQuery->get();

        $totalBarang = $all->count();
        $totalStok = $all->sum(function ($item) {
            $masuk = (int) ($item->total_masuk ?? 0);
            $keluar = (int) ($item->total_keluar ?? 0);
            return $masuk - $keluar;
        });

        $barangMenipis = $all->filter(function ($item) {
            $stok = ((int) ($item->total_masuk ?? 0)) - ((int) ($item->total_keluar ?? 0));
            return $stok >= 6 && $stok <= 20;
        })->count();

        $barangKritis = $all->filter(function ($item) {
            $stok = ((int) ($item->total_masuk ?? 0)) - ((int) ($item->total_keluar ?? 0));
            return $stok < 6;
        })->count();

        // Kirim data ke halaman Laporan Stok Barang
        return view('pages.warehouse.laporan-stok.index', [
            'laporans' => $laporans,
            'totalBarang' => $totalBarang,
            'totalStok' => $totalStok,
            'barangMenipis' => $barangMenipis,
            'barangKritis' => $barangKritis,
            'search' => $search,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
        ]);
    }

    /**
     * Buat closure untuk memfilter relasi berdasarkan rentang tanggal.
     * Digunakan oleh withSum() sehingga agregasi dijalankan oleh database.
     */
    private function dateRangeClosure($start, $end, string $dateColumn)
    {
        return function ($q) use ($start, $end, $dateColumn) {
            if ($start) {
                $q->whereDate($dateColumn, '>=', $start);
            }
            if ($end) {
                $q->whereDate($dateColumn, '<=', $end);
            }
        };
    }

    /**
     * Tentukan status stok berdasarkan aturan bisnis.
     */
    private function determineStatus(int $stok): string
    {
        if ($stok > 20) {
            return 'Aman';
        }

        if ($stok >= 6 && $stok <= 20) {
            return 'Menipis';
        }

        return 'Kritis';
    }
}
