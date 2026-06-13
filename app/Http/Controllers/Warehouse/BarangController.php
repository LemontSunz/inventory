<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Barang::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->get('kategori'));
        }

        // Pagination
        $barang = $query->latest()->paginate(10)->withQueryString();

        // Get unique categories for filter
        $kategoris = Barang::distinct()->pluck('kategori')->sort();

        return view('barang.index', compact('barang', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        try {
            Barang::create($request->validated());

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data barang');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        try {
            $barang->update($request->validated());

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            if (method_exists($barang, 'forceDelete')) {
                $barang->forceDelete();
            } else {
                $barang->delete();
            }

            return redirect()
                ->route('barang.index')
                ->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data barang');
        }
    }
}
