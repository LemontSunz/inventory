<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanStokController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        $tanggalAwalDate = null;
        $tanggalAkhirDate = null;
        try {
            $tanggalAwalDate = $tanggalAwal ? Carbon::parse($tanggalAwal)->startOfDay() : null;
            $tanggalAkhirDate = $tanggalAkhir ? Carbon::parse($tanggalAkhir)->endOfDay() : null;
        } catch (\Throwable $e) {
            // ignore invalid dates; fallback to null
        }

        // Ringkasan (gunakan data saat ini dari tabel barang)
        $totalBarang = Barang::count();
        $totalStok = (int) Barang::sum('stok');
        $barangMenipis = Barang::whereBetween('stok', [6, 20])->count();
        $barangKritis = Barang::where('stok', '<=', 5)->count();

        // Sub query: total masuk per barang (filter tanggal)
        $masukQuery = BarangMasuk::query();
        if ($tanggalAwalDate) {
            $masukQuery->whereDate('tanggal_masuk', '>=', $tanggalAwalDate->toDateString());
        }
        if ($tanggalAkhirDate) {
            $masukQuery->whereDate('tanggal_masuk', '<=', $tanggalAkhirDate->toDateString());
        }

        $keluarQuery = BarangKeluar::query();
        if ($tanggalAwalDate) {
            $keluarQuery->whereDate('tanggal_keluar', '>=', $tanggalAwalDate->toDateString());
        }
        if ($tanggalAkhirDate) {
            $keluarQuery->whereDate('tanggal_keluar', '<=', $tanggalAkhirDate->toDateString());
        }

        // Tabel laporan
        // NOTE: join memakai subquery agregat, dengan filter tanggal untuk total masuk/keluar.
        $query = Barang::query()->select([
            'barang.id as barang_id',
            'barang.kode_barang',
            'barang.nama_barang',
            'barang.stok as stok_saat_ini',
            DB::raw('COALESCE(m.total_masuk, 0) as total_barang_masuk'),
            DB::raw('COALESCE(k.total_keluar, 0) as total_barang_keluar'),
        ])
            ->leftJoin(DB::raw('(' . $masukQuery->selectRaw('barang_id, SUM(qty_masuk) as total_masuk')->groupBy('barang_id')->toSql() . ') as m'), 'barang.id', '=', 'm.barang_id')
            ->leftJoin(DB::raw('(' . $keluarQuery->selectRaw('barang_id, SUM(jumlah_keluar) as total_keluar')->groupBy('barang_id')->toSql() . ') as k'), 'barang.id', '=', 'k.barang_id');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('barang.kode_barang', 'like', "%{$search}%")
                    ->orWhere('barang.nama_barang', 'like', "%{$search}%");
            });
        }

        // Pagination
        $laporans = $query
            ->orderByDesc('barang.updated_at')
            ->paginate(10)
            ->withQueryString();

        // Hitung status di view (berdasarkan stok saat ini)
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
}

