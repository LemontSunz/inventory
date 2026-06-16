@php
    $statuses = App\Models\Driver::statuses();
    $licenseClasses = App\Models\Driver::licenseClasses();
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-4 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Pengemudi</label>
            <input type="text" name="name" value="{{ old('name', $driver->name ?? '') }}" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Nomor Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $driver->phone ?? '') }}" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Unit / Kendaraan</label>
            <input type="text" name="vehicle_type" value="{{ old('vehicle_type', $driver->vehicle_type ?? '') }}" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Rute Ditugaskan</label>
            <input type="text" name="assigned_route" value="{{ old('assigned_route', $driver->assigned_route ?? '') }}"
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
        </div>
    </div>

    <div class="space-y-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Kelas SIM</label>
            <select name="license_class" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                <option value="">Pilih Kelas SIM</option>
                @foreach($licenseClasses as $licenseClass)
                    <option value="{{ $licenseClass }}" {{ old('license_class', $driver->license_class ?? '') === $licenseClass ? 'selected' : '' }}>
                        {{ $licenseClass }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Masa Berlaku SIM</label>
            <input type="date" name="license_expiry_date" value="{{ old('license_expiry_date', isset($driver) ? $driver->license_expiry_date->toDateString() : '') }}" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Status Armada</label>
            <select name="status" required
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                <option value="">Pilih Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ old('status', $driver->status ?? '') === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Catatan</label>
            <textarea name="notes" rows="4"
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">{{ old('notes', $driver->notes ?? '') }}</textarea>
        </div>
    </div>
</div>
