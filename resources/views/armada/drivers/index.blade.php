@extends('layouts.app')

@section('title', 'Armada - Daftar Pengemudi')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="Armada"
        title="Daftar Pengemudi"
        description="Kelola data pengemudi untuk mendukung proses distribusi barang secara terstruktur, akurat, dan efisien."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('armada.drivers.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pengemudi
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $today = now()->startOfDay();
        $totalDrivers = App\Models\Driver::count();
        $availableDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_AVAILABLE)->count();
        $onRouteDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_ON_ROUTE)->count();
        $inactiveDrivers = App\Models\Driver::where('status', App\Models\Driver::STATUS_INACTIVE)->count();
        $simActive = App\Models\Driver::whereNotNull('license_expiry_date')->where('license_expiry_date', '>', $today->copy()->addDays(30))->count();
        $simExpiring = App\Models\Driver::whereNotNull('license_expiry_date')->whereBetween('license_expiry_date', [$today, $today->copy()->addDays(30)])->count();
        $simExpired = App\Models\Driver::whereNotNull('license_expiry_date')->where('license_expiry_date', '<', $today)->count();
    @endphp

    <div class="grid gap-4 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Pengemudi</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah seluruh pengemudi yang terdaftar pada sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Pengemudi Tersedia</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $availableDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Siap ditugaskan untuk proses distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Pengiriman</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $onRouteDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Sedang menjalankan proses distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Tidak Aktif</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $inactiveDrivers }}</p>
            <p class="mt-2 text-sm text-slate-500">Pengemudi yang sedang tidak bertugas atau dinonaktifkan.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('armada.drivers.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
        <x-filter.search-input
            name="search"
            label="Cari Pengemudi"
            value="{{ request('search') }}"
            placeholder="Nama pengemudi, kode, atau kendaraan"
        />

        <x-filter.select-input name="status" label="Status Armada">
            <option value="">Semua Status</option>
            @foreach(App\Models\Driver::statuses() as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </x-filter.select-input>

        <div class="flex items-end gap-3">
            <x-filter.filter-button>Terapkan</x-filter.filter-button>
            <x-filter.reset-button :href="route('armada.drivers.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%]">
            <x-table.table-wrapper title="Tabel Pengemudi" description="Daftar lengkap pengemudi beserta informasi armada." :count="$drivers->total()">
                @if($drivers->count())
                    <table class="table-standard">
                        <thead>
                            <tr>
                                <x-table.table-header label="Kode" align="center" class="table-col-code" :sortable="true" sort-route="armada.drivers.index" column="driver_code" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Nama" align="left" class="px-4 py-3 font-semibold" :sortable="true" sort-route="armada.drivers.index" column="name" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="SIM" align="center" class="whitespace-nowrap" />
                                <x-table.table-header label="Status" align="center" class="table-col-status" :sortable="true" sort-route="armada.drivers.index" column="status" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Aksi" align="center" class="table-col-actions" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($drivers as $driver)
                                @php $style = App\Models\Driver::statusStyles()[$driver->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400']; @endphp
                                <x-table.table-row>
                                    <x-table.table-cell align="center" class="table-col-code font-semibold text-slate-900">{{ $driver->driver_code }}</x-table.table-cell>
                                    <x-table.table-cell align="left">{{ $driver->name }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="whitespace-nowrap">
                                        {{ $driver->license_class }}
                                        <span class="block text-xs text-slate-400">Exp {{ optional($driver->license_expiry_date)->format('d M Y') ?? '-' }}</span>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-status">
                                        <span class="badge-consistent {{ $style['bg'] }} {{ $style['text'] }}">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }} mr-2"></span>
                                            {{ $driver->status }}
                                        </span>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-actions">
                                        <x-table.action-buttons
                                            :detail-route="route('armada.drivers.show', $driver)"
                                            :show-detail="true"
                                            :edit-route="auth()->user()->role === 'admin_gudang' ? route('armada.drivers.edit', $driver) : null"
                                            :show-edit="auth()->user()->role === 'admin_gudang'"
                                            :delete-route="auth()->user()->role === 'admin_gudang' ? route('armada.drivers.destroy', $driver) : null"
                                            :show-delete="auth()->user()->role === 'admin_gudang'"
                                            delete-confirm="Hapus driver ini?"
                                            container-class="justify-center"
                                        />
                                    </x-table.table-cell>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-table.table-empty title="Belum ada pengemudi armada" description="Tambahkan pengemudi untuk mulai mengelola tim pengiriman." :action-route="auth()->user()->role === 'admin_gudang' ? route('armada.drivers.create') : null" action-label="Tambah Pengemudi" />
                @endif

                @if($drivers->count())
                    <x-table.pagination :paginator="$drivers" />
                @endif
            </x-table.table-wrapper>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Status SIM Pengemudi</h3>
                <p class="mt-2 text-sm text-slate-500">Ringkasan kondisi dokumen SIM seluruh pengemudi.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">SIM Aktif</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $simActive }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">SIM Akan Berakhir</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-700">{{ $simExpiring }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">SIM Kedaluwarsa</p>
                        <p class="mt-3 text-3xl font-semibold text-rose-700">{{ $simExpired }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
