@extends('layouts.app')

@section('title', 'Armada - Daftar Kendaraan')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="Armada"
        title="Daftar Kendaraan"
        description="Kelola data kendaraan yang digunakan dalam proses distribusi barang untuk mendukung operasional logistik."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('kendaraan.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kendaraan
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
        $totalKendaraan = App\Models\Kendaraan::count();
        $totalSiap = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_SIAP)->count();
        $totalBertugas = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_BERTUGAS)->count();
        $totalPerawatan = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_PERAWATAN)->count();
        $kendaraanAktif = $totalSiap;
        $kendaraanPerawatan = $totalPerawatan;
        $dataLengkap = App\Models\Kendaraan::whereNotNull('nama_kendaraan')
            ->whereNotNull('plat_nomor')
            ->whereNotNull('jenis_kendaraan')
            ->whereNotNull('kapasitas_muatan')
            ->whereNotNull('status')
            ->count();
    @endphp

    <div class="grid gap-4 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Kendaraan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalKendaraan }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah seluruh kendaraan yang terdaftar pada sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Siap Pakai</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $totalSiap }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan siap digunakan untuk proses distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sedang Bertugas</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalBertugas }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang digunakan untuk distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $totalPerawatan }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang menjalani perawatan atau perbaikan.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('kendaraan.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
        <x-filter.search-input
            name="search"
            label="Cari Kendaraan"
            value="{{ request('search') }}"
            placeholder="Kode, nama, plat, jenis"
        />

        <x-filter.select-input name="status" label="Status Armada">
            <option value="">Semua Status</option>
            @foreach(App\Models\Kendaraan::statuses() as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </x-filter.select-input>

        <div class="flex items-end gap-3">
            <x-filter.filter-button>Terapkan</x-filter.filter-button>
            <x-filter.reset-button :href="route('kendaraan.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%]">
            <x-table.table-wrapper title="Tabel Kendaraan" description="Daftar lengkap kendaraan beserta informasi armada." :count="$kendaraan->total()">
                @if($kendaraan->count())
                    <table class="table-standard">
                        <thead>
                            <tr>
                                <x-table.table-header label="Kode" align="center" class="table-col-code" :sortable="true" sort-route="kendaraan.index" column="kode_kendaraan" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Nama" align="left" class="px-4 py-3 font-semibold" :sortable="true" sort-route="kendaraan.index" column="nama_kendaraan" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Jenis" align="center" class="px-4 py-3 font-semibold" :sortable="true" sort-route="kendaraan.index" column="jenis_kendaraan" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Plat" align="center" class="px-4 py-3 font-semibold" :sortable="true" sort-route="kendaraan.index" column="plat_nomor" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Muatan" align="center" class="px-4 py-3 font-semibold" />
                                <x-table.table-header label="Status" align="center" class="table-col-status" :sortable="true" sort-route="kendaraan.index" column="status" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Aksi" align="center" class="table-col-actions" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kendaraan as $item)
                                @php $style = App\Models\Kendaraan::statusStyles()[$item->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400']; @endphp
                                <x-table.table-row>
                                    <x-table.table-cell align="center" class="table-col-code font-semibold text-slate-900">{{ $item->kode_kendaraan }}</x-table.table-cell>
                                    <x-table.table-cell align="left">{{ $item->nama_kendaraan }}</x-table.table-cell>
                                    <x-table.table-cell align="center">{{ $item->jenis_kendaraan }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="whitespace-nowrap">{{ $item->plat_nomor }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-qty">{{ number_format($item->kapasitas_muatan, 0) }} kg</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-status">
                                        <span class="badge-consistent {{ $style['bg'] }} {{ $style['text'] }}">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }} mr-2"></span>
                                            {{ $item->status }}
                                        </span>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-actions">
                                        <x-table.action-buttons
                                            :detail-route="route('kendaraan.show', $item)"
                                            :show-detail="true"
                                            :edit-route="auth()->user()->role === 'admin_gudang' ? route('kendaraan.edit', $item) : null"
                                            :show-edit="auth()->user()->role === 'admin_gudang'"
                                            :delete-route="auth()->user()->role === 'admin_gudang' ? route('kendaraan.destroy', $item) : null"
                                            :show-delete="auth()->user()->role === 'admin_gudang'"
                                            delete-confirm="Hapus kendaraan ini?"
                                            container-class="justify-center"
                                        />
                                    </x-table.table-cell>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-table.table-empty title="Belum ada data kendaraan" description="Tambahkan kendaraan armada baru sekarang." :action-route="auth()->user()->role === 'admin_gudang' ? route('kendaraan.create') : null" action-label="Tambah Kendaraan" />
                @endif

                @if($kendaraan->count())
                    <x-table.pagination :paginator="$kendaraan" />
                @endif
            </x-table.table-wrapper>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Status Kendaraan</h3>
                <p class="mt-2 text-sm text-slate-500">Ringkasan kondisi data kendaraan pada sistem logistik.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Kendaraan Aktif</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $kendaraanAktif }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-700">{{ $kendaraanPerawatan }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Data Lengkap</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $dataLengkap }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
