<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RackLocation;
use Illuminate\Http\Request;

class LokasiRakController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search', ''));

        $query = RackLocation::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('label', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $lokasiRaks = $query
            ->withCount('incomingGoodsDetails')
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        $totalLocations = RackLocation::count();
        $activeRacks = RackLocation::has('incomingGoodsDetails')->count();
        $unusedRacks = $totalLocations - $activeRacks;
        $lastUpdated = RackLocation::latest('updated_at')->value('updated_at');

        return view('rak-lokasi.index', [
            'lokasiRaks' => $lokasiRaks,
            'search' => $search,
            'totalLocations' => $totalLocations,
            'activeRacks' => $activeRacks,
            'unusedRacks' => $unusedRacks,
            'lastUpdated' => $lastUpdated,
        ]);
    }

    public function create()
    {
        return view('rak-lokasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:rack_locations,code',
            'label' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        RackLocation::create($data);

        return redirect()
            ->route('lokasi-rak.index')
            ->with('success', 'Lokasi rak berhasil disimpan.');
    }

    public function edit(RackLocation $rakLocation)
    {
        return view('rak-lokasi.edit', ['rakLocation' => $rakLocation]);
    }

    public function update(Request $request, RackLocation $rakLocation)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:rack_locations,code,' . $rakLocation->id,
            'label' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $rakLocation->update($data);

        return redirect()
            ->route('lokasi-rak.index')
            ->with('success', 'Lokasi rak berhasil diperbarui.');
    }

    public function destroy(RackLocation $rakLocation)
    {
        $rakLocation->delete();

        return redirect()
            ->route('lokasi-rak.index')
            ->with('success', 'Lokasi rak berhasil dihapus.');
    }
}
