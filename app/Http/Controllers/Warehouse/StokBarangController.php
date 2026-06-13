<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        $search = trim((string) $request->get('search', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        $status = $request->get('status', 'semua');
        $status = is_string($status) ? strtolower($status) : 'semua';

        // status filter sesuai requirement:
        // - normal  : > 20
        // - rendah  : 6 - 20
        // - kritis  : <= 5
        $query->when($status === 'normal', function ($q) {
            $q->where('stok', '>', 20);
        });

        $query->when($status === 'rendah', function ($q) {
            $q->whereBetween('stok', [6, 20]);
        });

        $query->when($status === 'kritis', function ($q) {
            $q->where('stok', '<=', 5);
        });


        $barangs = $query
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->withQueryString();

        // Ringkasan kartu berdasarkan data yang sama dengan query aktif
        $ringkasanQuery = clone $query;

        $totalBarang = (clone $ringkasanQuery)->count();
        $totalStok = (int) (clone $ringkasanQuery)->sum('stok');

        $barangAman = (clone $ringkasanQuery)->where('stok', '>', 20)->count();
        $barangMenipis = (clone $ringkasanQuery)->whereBetween('stok', [6, 20])->count();
        $barangKritis = (clone $ringkasanQuery)->where('stok', '<=', 5)->count();




        return view('pages.warehouse.stock-management.index', [
            'barangs' => $barangs,
            'totalBarang' => $totalBarang,
            'totalStok' => $totalStok,
            'barangAman' => $barangAman,
            'barangMenipis' => $barangMenipis,
            'barangKritis' => $barangKritis,
            'status' => $status,
            'search' => $search,
        ]);
    }
}

