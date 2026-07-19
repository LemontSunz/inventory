<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($search = $request->get('search')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('driver_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Sortable columns
        $sortable = ['driver_code', 'name', 'status'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        // Validate sort column and direction
        if (!in_array($sort, $sortable) && $sort !== 'created_at') {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // Apply sorting
        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $drivers = $query->paginate(10)->withQueryString();

        return view('armada.drivers.index', compact('drivers', 'sort', 'direction'));
    }

    public function create()
    {
        return view('armada.drivers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'license_class' => ['required', Rule::in(Driver::licenseClasses())],
            'license_expiry_date' => 'required|date',
            'status' => ['required', Rule::in(Driver::statuses())],
            'notes' => 'nullable|string|max:1000',
        ]);

        Driver::create([
            'driver_code' => Driver::generateCode(),
            'name' => $data['name'],
            'phone' => $data['phone'],
            'license_class' => $data['license_class'],
            'license_expiry_date' => $data['license_expiry_date'],
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('armada.drivers.index')
            ->with('success', 'Driver armada berhasil ditambahkan.');
    }

    public function show(Driver $driver)
    {
        return view('armada.drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('armada.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'license_class' => ['required', Rule::in(Driver::licenseClasses())],
            'license_expiry_date' => 'required|date',
            'status' => ['required', Rule::in(Driver::statuses())],
            'notes' => 'nullable|string|max:1000',
        ]);

        $driver->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'license_class' => $data['license_class'],
            'license_expiry_date' => $data['license_expiry_date'],
            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('armada.drivers.index')
            ->with('success', 'Data driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('armada.drivers.index')
            ->with('success', 'Driver armada berhasil dihapus.');
    }
}
