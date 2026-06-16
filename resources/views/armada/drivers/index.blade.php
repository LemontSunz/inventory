@extends('layouts.app')

@section('title', 'Armada - Daftar Driver')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Armada</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Daftar Driver</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola armada driver Anda secara profesional dengan status, rute, dan sertifikasi SIM yang jelas.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="{{ route('armada.drivers.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Tambah Driver Baru</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $totalDrivers = App\Models\Driver::count();
        $availableDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_AVAILABLE)->count();
        $onRouteDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_ON_ROUTE)->count();
        $inactiveDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_INACTIVE)->count();
    @endphp

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Driver</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Semua armada driver terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Tersedia</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $availableDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Siap ditugaskan segera.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sedang Bertugas</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $onRouteDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Sedang dalam pengiriman aktif.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Tidak Aktif</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $inactiveDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Driver yang perlu ditinjau atau diaktifkan ulang.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('armada.drivers.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Driver</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Nama, kode, kendaraan, atau rute"
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Status Armada</label>
                <select name="status" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Semua Status</option>
                    @foreach(App\Models\Driver::statuses() as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800">Terapkan</button>
                <a href="{{ route('armada.drivers.index') }}" class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Reset</a>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%] rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tabel Driver</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar lengkap driver beserta informasi armada.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $drivers->total() }}</div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Kode</th>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">Kendaraan</th>
                            <th class="px-4 py-3 font-semibold">Rute</th>
                            <th class="px-4 py-3 font-semibold">SIM</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($drivers as $driver)
                            @php $style = App\Models\Driver::statusStyles()[$driver->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400']; @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $driver->driver_code }}</td>
                                <td class="px-4 py-4">{{ $driver->name }}</td>
                                <td class="px-4 py-4">{{ $driver->vehicle_type }}</td>
                                <td class="px-4 py-4">{{ $driver->assigned_route ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    {{ $driver->license_class }}
                                    <span class="block text-xs text-slate-400">Exp {{ optional($driver->license_expiry_date)->format('d M Y') ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $style['bg'] }} {{ $style['text'] }}">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
                                        {{ $driver->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('armada.drivers.show', $driver) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('armada.drivers.edit', $driver) }}" class="rounded-2xl bg-blue-50 px-3 py-2 text-[11px] font-semibold text-blue-700 hover:bg-blue-100">Edit</a>
                                        <form action="{{ route('armada.drivers.destroy', $driver) }}" method="POST" class="inline" onsubmit="return confirm('Hapus driver ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center text-slate-500">
                                    Belum ada driver armada. Tambahkan driver untuk mulai mengelola tim pengiriman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $drivers->firstItem() ?? 0 }}</strong> sampai <strong>{{ $drivers->lastItem() ?? 0 }}</strong> dari <strong>{{ $drivers->total() }}</strong>
                </div>
                <div>{{ $drivers->links() }}</div>
            </div>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Insight Armada</h3>
                <p class="mt-2 text-sm text-slate-500">Pantau kesiapan armada dan rute utama dengan cepat.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Driver Siap</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $availableDrivers }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Pengiriman</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-700">{{ $onRouteDrivers }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Driver Perlu Tinjau</p>
                        <p class="mt-3 text-3xl font-semibold text-rose-700">{{ $inactiveDrivers }}</p>
                    </div>
                </div>
            </div>


        </aside>
    </div>
</div>
@endsection
