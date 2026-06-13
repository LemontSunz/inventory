<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class StockManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Search: kode, nama, kategori
        $search = $request->get('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter status stok
        $status = $request->get('status', 'semua');
        $status = is_string($status) ? strtolower($status) : 'semua';

        $query->when($status === 'aman', function ($q) {
            $q->where('stok', '>', 20);
        });

        $query->when($status === 'menipis', function ($q) {
            $q->whereBetween('stok', [6, 20]);
        });

        $query->when($status === 'kritis', function ($q) {
            $q->where('stok', '<=', 5);
        });

        $barang = $query->orderByDesc('updated_at')->paginate(10)->withQueryString();

        // Ringkasan
        $totalBarang = Barang::count();
        $totalStok = (int) Barang::sum('stok');

        $barangMenipis = Barang::whereBetween('stok', [6, 20])->count();
        $barangKritis = Barang::where('stok', '<=', 5)->count();

        return view('pages.warehouse.stock-management.index', [
            'barangs' => $barang,
            'totalBarang' => $totalBarang,
            'totalStok' => $totalStok,
            'barangMenipis' => $barangMenipis,
            'barangKritis' => $barangKritis,
            'status' => $status,
            'search' => $search,
        ]);
    }
}

