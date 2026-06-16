<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        if ($search = $request->get('search')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('kode_kendaraan', 'like', "%{$search}%")
                    ->orWhere('nama_kendaraan', 'like', "%{$search}%")
                    ->orWhere('plat_nomor', 'like', "%{$search}%")
                    ->orWhere('jenis_kendaraan', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $totalKendaraan = (clone $query)->count();
        $totalSiap = (clone $query)->where('status', Kendaraan::STATUS_SIAP)->count();
        $totalBertugas = (clone $query)->where('status', Kendaraan::STATUS_BERTUGAS)->count();
        $totalPerawatan = (clone $query)->where('status', Kendaraan::STATUS_PERAWATAN)->count();

        $kendaraan = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('kendaraan.index', compact('kendaraan', 'totalKendaraan', 'totalSiap', 'totalBertugas', 'totalPerawatan'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis_kendaraan' => ['required', Rule::in(Kendaraan::jenisKendaraan())],
            'plat_nomor' => 'required|string|max:50|unique:kendaraan,plat_nomor',
            'kapasitas_muatan' => 'required|integer|min:0',
            'kilometer' => 'required|integer|min:0',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . date('Y'),
            'warna' => 'required|string|max:50',
            'status' => ['required', Rule::in(Kendaraan::statuses())],
            'catatan' => 'nullable|string|max:1000',
        ]);

        Kendaraan::create([
            'kode_kendaraan' => Kendaraan::generateCode(),
            'nama_kendaraan' => $data['nama_kendaraan'],
            'jenis_kendaraan' => $data['jenis_kendaraan'],
            'plat_nomor' => $data['plat_nomor'],
            'kapasitas_muatan' => $data['kapasitas_muatan'],
            'kilometer' => $data['kilometer'],
            'tahun_pembuatan' => $data['tahun_pembuatan'],
            'warna' => $data['warna'],
            'status' => $data['status'],
            'catatan' => $data['catatan'] ?? null,
        ]);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis_kendaraan' => ['required', Rule::in(Kendaraan::jenisKendaraan())],
            'plat_nomor' => ['required', 'string', 'max:50', Rule::unique('kendaraan', 'plat_nomor')->ignore($kendaraan->id)],
            'kapasitas_muatan' => 'required|integer|min:0',
            'kilometer' => 'required|integer|min:0',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . date('Y'),
            'warna' => 'required|string|max:50',
            'status' => ['required', Rule::in(Kendaraan::statuses())],
            'catatan' => 'nullable|string|max:1000',
        ]);

        $kendaraan->update([
            'nama_kendaraan' => $data['nama_kendaraan'],
            'jenis_kendaraan' => $data['jenis_kendaraan'],
            'plat_nomor' => $data['plat_nomor'],
            'kapasitas_muatan' => $data['kapasitas_muatan'],
            'kilometer' => $data['kilometer'],
            'tahun_pembuatan' => $data['tahun_pembuatan'],
            'warna' => $data['warna'],
            'status' => $data['status'],
            'catatan' => $data['catatan'] ?? null,
        ]);

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
