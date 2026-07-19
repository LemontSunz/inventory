<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\IncomingGoodsDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        // Ringkasan (gunakan data saat ini dari tabel barang)
        $totalBarang = Barang::count();
        $totalStok = (int) Barang::sum('stok');
        $barangMenipis = Barang::whereBetween('stok', [6, 20])->count();
        $barangKritis = Barang::where('stok', '<=', 5)->count();

        // Sub query: total masuk per barang (filter bulan/tahun) from incoming goods details
        $masukQuery = IncomingGoodsDetail::query()
            ->join('incoming_goods', 'incoming_goods_details.incoming_goods_id', '=', 'incoming_goods.id');

        if ($request->filled('bulan')) {
            $masukQuery->whereMonth('incoming_goods.receiving_date', $bulan);
        }
        if ($request->filled('tahun')) {
            $masukQuery->whereYear('incoming_goods.receiving_date', $tahun);
        }

        $keluarQuery = BarangKeluar::query();
        if ($request->filled('bulan')) {
            $keluarQuery->whereMonth('tanggal_keluar', $bulan);
        }
        if ($request->filled('tahun')) {
            $keluarQuery->whereYear('tanggal_keluar', $tahun);
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
            ->leftJoinSub(
                $masukQuery->selectRaw('incoming_goods_details.item_id as barang_id, SUM(incoming_goods_details.quantity_received) as total_masuk')->groupBy('incoming_goods_details.item_id'),
                'm',
                function ($join) {
                    $join->on('barang.id', '=', 'm.barang_id');
                }
            )
            ->leftJoinSub(
                $keluarQuery->selectRaw('barang_id, SUM(jumlah_keluar) as total_keluar')->groupBy('barang_id'),
                'k',
                function ($join) {
                    $join->on('barang.id', '=', 'k.barang_id');
                }
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('barang.kode_barang', 'like', "%{$search}%")
                    ->orWhere('barang.nama_barang', 'like', "%{$search}%");
            });
        }

        // Sortable columns
        $sortable = ['barang.kode_barang', 'barang.nama_barang', 'barang.stok', 'total_barang_masuk', 'total_barang_keluar'];
        $sort = $request->get('sort', 'barang.updated_at');
        $direction = $request->get('direction', 'desc');

        // Validate sort column and direction
        if (!in_array($sort, $sortable) && $sort !== 'barang.updated_at') {
            $sort = 'barang.updated_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // Pagination
        $laporans = $query
            ->orderBy($sort, $direction)
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
            'bulan' => $bulan,
            'tahun' => $tahun,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $search = trim((string) $request->get('search', ''));
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $totalBarang = Barang::count();
        $totalStok = (int) Barang::sum('stok');

        // Sub query: total masuk per barang (filter bulan/tahun) from incoming goods details
        $masukQuery = IncomingGoodsDetail::query()
            ->join('incoming_goods', 'incoming_goods_details.incoming_goods_id', '=', 'incoming_goods.id');

        if ($request->filled('bulan')) {
            $masukQuery->whereMonth('incoming_goods.receiving_date', $bulan);
        }
        if ($request->filled('tahun')) {
            $masukQuery->whereYear('incoming_goods.receiving_date', $tahun);
        }

        $keluarQuery = BarangKeluar::query();
        if ($request->filled('bulan')) {
            $keluarQuery->whereMonth('tanggal_keluar', $bulan);
        }
        if ($request->filled('tahun')) {
            $keluarQuery->whereYear('tanggal_keluar', $tahun);
        }

        // Tabel laporan - Get all data without pagination for PDF
        $query = Barang::query()->select([
            'barang.id as barang_id',
            'barang.kode_barang',
            'barang.nama_barang',
            'barang.stok as stok_saat_ini',
            DB::raw('COALESCE(m.total_masuk, 0) as total_barang_masuk'),
            DB::raw('COALESCE(k.total_keluar, 0) as total_barang_keluar'),
        ])
            ->leftJoinSub(
                $masukQuery->selectRaw('incoming_goods_details.item_id as barang_id, SUM(incoming_goods_details.quantity_received) as total_masuk')->groupBy('incoming_goods_details.item_id'),
                'm',
                function ($join) {
                    $join->on('barang.id', '=', 'm.barang_id');
                }
            )
            ->leftJoinSub(
                $keluarQuery->selectRaw('barang_id, SUM(jumlah_keluar) as total_keluar')->groupBy('barang_id'),
                'k',
                function ($join) {
                    $join->on('barang.id', '=', 'k.barang_id');
                }
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('barang.kode_barang', 'like', "%{$search}%")
                    ->orWhere('barang.nama_barang', 'like', "%{$search}%");
            });
        }

        $laporans = $query->orderByDesc('barang.updated_at')->get();

        $pdf = Pdf::loadView('pdfs.laporan-stok', [
            'laporans' => $laporans,
            'totalBarang' => $totalBarang,
            'totalStok' => $totalStok,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'printDate' => now(),
        ]);

        return $pdf->download('Laporan-Stok-Barang-' . now()->format('Y-m-d-His') . '.pdf');
    }
}

