@extends('layouts.app')

@section('title', 'Armada - Detail Driver')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Detail Driver</h1>
            <p class="mt-2 text-slate-600">Ringkasan lengkap armada dan status layanan.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('armada.drivers.edit', $driver) }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Edit</a>
            <a href="{{ route('armada.drivers.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">Kembali</a>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[1fr_0.9fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Profil Driver</h2>
            <dl class="mt-6 space-y-5 text-sm text-slate-700">
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Kode Driver</dt>
                    <dd>{{ $driver->driver_code }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Nama</dt>
                    <dd>{{ $driver->name }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Telepon</dt>
                    <dd>{{ $driver->phone }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Kendaraan</dt>
                    <dd>{{ $driver->vehicle_type }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Rute Ditugaskan</dt>
                    <dd>{{ $driver->assigned_route ?? '-' }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Kelas SIM</dt>
                    <dd>{{ $driver->license_class }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Masa Berlaku SIM</dt>
<dd>{{ optional($driver->license_expiry_date)->translatedFormat('d F Y') ?? '-' }}</dd>
                </div>
                <div class="grid gap-2 sm:grid-cols-2">
                    <dt class="font-semibold text-slate-600">Status Armada</dt>
                    <dd>
                        @php $style = App\Models\Driver::statusStyles()[$driver->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700']; @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $style['bg'] }} {{ $style['text'] }}">{{ $driver->status }}</span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Catatan dan Info Tambahan</h2>
            <div class="mt-6 rounded-3xl bg-white p-5 text-sm text-slate-700 shadow-sm">
                <p class="whitespace-pre-line">{{ $driver->notes ?? 'Tidak ada catatan tambahan.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
