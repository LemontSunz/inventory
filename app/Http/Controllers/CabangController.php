<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $query = Cabang::query();

        if ($request->filled('search')) {
            $search = $request->get('search');

            $query->where('kode_cabang', 'like', "%{$search}%")
                ->orWhere('nama_cabang', 'like', "%{$search}%")
                ->orWhere('kota', 'like', "%{$search}%");
        }

        $cabangs = $query->latest()->paginate(10)->withQueryString();

        return view('cabang.index', compact('cabangs'));
    }

    public function create()
    {
        return view('cabang.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_cabang' => 'required|string|max:50|unique:cabang,kode_cabang',
            'nama_cabang' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        try {
            Cabang::create($data);

            return redirect()
                ->route('cabang.index')
                ->with('success', 'Data cabang berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data cabang');
        }
    }

    public function edit(Cabang $cabang)
    {
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request, Cabang $cabang)
    {
        $data = $request->validate([
            'kode_cabang' => 'required|string|max:50|unique:cabang,kode_cabang,' . $cabang->id,
            'nama_cabang' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
        ]);

        try {
            $cabang->update($data);

            return redirect()
                ->route('cabang.index')
                ->with('success', 'Data cabang berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data cabang');
        }
    }

    public function destroy(Cabang $cabang)
    {
        try {
            $cabang->delete();

            return redirect()
                ->route('cabang.index')
                ->with('success', 'Data cabang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data cabang');
        }
    }
}

