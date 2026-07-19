<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\IncomingGoods;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // CARD 1 - Total Barang
        $totalBarang = Barang::count();

        // CARD 2 - Barang Masuk Hari Ini
        $barangMasukHariIni = IncomingGoods::whereDate('receiving_date', Carbon::today())->count();

        // CARD 3 - Barang Keluar Hari Ini
        $barangKeluarHariIni = BarangKeluar::whereDate('tanggal_keluar', Carbon::today())->count();

        // CARD 4 - Stok Kritis (stok <= 5)
        $stokKritis = Barang::where('stok', '<=', 5)->count();

        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subMonths(11)->startOfMonth();
        $endDate = $currentDate->copy()->endOfMonth();

        $monthlyLabels = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $incomingMonthly = IncomingGoods::selectRaw('YEAR(receiving_date) as year, MONTH(receiving_date) as month, COUNT(*) as total')
            ->whereBetween('receiving_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => $row->year . '-' . $row->month);

        $outgoingMonthly = BarangKeluar::selectRaw('YEAR(tanggal_keluar) as year, MONTH(tanggal_keluar) as month, COUNT(*) as total')
            ->whereBetween('tanggal_keluar', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => $row->year . '-' . $row->month);

        $period = collect(range(11, 0, -1))
            ->map(fn ($monthsAgo) => $currentDate->copy()->subMonths($monthsAgo)->startOfMonth());

        $chartLabels = $period->map(fn ($date) => $monthlyLabels[$date->month])->all();
        $chartMasukData = $period->map(fn ($date) => $incomingMonthly->get($date->year . '-' . $date->month)->total ?? 0)->all();
        $chartKeluarData = $period->map(fn ($date) => $outgoingMonthly->get($date->year . '-' . $date->month)->total ?? 0)->all();

        // AKTIVITAS TERBARU - Get latest 5 activities combined from masuk and keluar
        $incomingActivities = IncomingGoods::select(
            'id',
            'receiving_code as code',
            'receiving_date as activity_date',
            'description',
            \DB::raw("'masuk' as type")
        )
            ->orderBy('receiving_date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->activity_date = $item->activity_date ? Carbon::parse($item->activity_date) : null;
                return $item;
            });

        $outgoingActivities = BarangKeluar::select(
            'id',
            'nomor_pengiriman as code',
            'tanggal_keluar as activity_date',
            'keterangan as description',
            \DB::raw("'keluar' as type")
        )
            ->orderBy('tanggal_keluar', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->activity_date = $item->activity_date ? Carbon::parse($item->activity_date) : null;
                return $item;
            });

        $activities = collect($incomingActivities)
            ->merge($outgoingActivities)
            ->filter(fn ($item) => $item->activity_date !== null)
            ->sortByDesc('activity_date')
            ->take(5);

        return view('pages.dashboard.index', [
            'totalBarang' => $totalBarang,
            'barangMasukHariIni' => $barangMasukHariIni,
            'barangKeluarHariIni' => $barangKeluarHariIni,
            'stokKritis' => $stokKritis,
            'activities' => $activities,
            'chartLabels' => $chartLabels,
            'chartMasukData' => $chartMasukData,
            'chartKeluarData' => $chartKeluarData,
        ]);
    }
}
