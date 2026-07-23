@extends('layouts.app')

@section('title', 'Lokasi Rak - PT. Karya Makmur Mesindo')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="GUDANG"
        title="Kelola Lokasi Rak"
        description="Kelola lokasi penyimpanan barang di gudang agar proses pencarian dan penataan barang lebih efisien."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('lokasi-rak.create') }}" class="group inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Lokasi Rak
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Lokasi</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalLocations }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah lokasi rak yang terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Aktif</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $activeRacks }}</p>
            <p class="mt-2 text-sm text-slate-500">Rak yang sedang digunakan.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Belum Digunakan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $unusedRacks }}</p>
            <p class="mt-2 text-sm text-slate-500">Rak yang belum terisi transaksi.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Terakhir Diperbarui</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ optional($lastUpdated)->format('d M Y') ?? '-' }}</p>
            <p class="mt-2 text-sm text-slate-500">Tanggal pembaruan data lokasi rak terakhir.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('lokasi-rak.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
        <x-filter.search-input
            name="search"
            label="Cari Lokasi Rak"
            value="{{ $search }}"
            placeholder="Cari kode atau label..."
        />
        <div class="hidden lg:block"></div>
        <div class="flex items-end gap-3">
            <x-filter.filter-button>Cari</x-filter.filter-button>
            <x-filter.reset-button :href="route('lokasi-rak.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <div class="flex flex-col gap-5 xl:grid xl:grid-cols-5 xl:items-stretch xl:gap-6">
        <div class="xl:col-span-4">
            <x-table.table-wrapper title="Daftar Lokasi Rak" description="Kelola rak berdasarkan kode, label, dan status penggunaan." :count="$lokasiRaks->total()">
                @if($lokasiRaks->count())
                    <table class="table-standard">
                        <thead>
                            <tr>
                                <x-table.table-header label="No" align="center" class="table-col-no" />
                                <x-table.table-header label="Kode Rak" align="center" class="table-col-code" />
                                <x-table.table-header label="Label" align="left" />
                                <x-table.table-header label="Deskripsi" align="left" />
                                <x-table.table-header label="Penggunaan" align="left" class="whitespace-nowrap" />
                                <x-table.table-header label="Aksi" align="center" class="table-col-actions" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lokasiRaks as $item)
                                <x-table.table-row>
                                    <x-table.table-cell align="center" class="table-col-no font-medium text-slate-900">{{ $lokasiRaks->firstItem() + $loop->index }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-code">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700">{{ $item->code }}</span>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="left">{{ $item->label ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="left" wrap="true" class="text-slate-500">{{ \Illuminate\Support\Str::limit($item->description ?? '-', 120) }}</x-table.table-cell>
                                    <x-table.table-cell align="left" class="whitespace-nowrap">
                                        <span class="badge-consistent bg-slate-100 text-slate-700">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $item->incoming_goods_details_count ? 'bg-emerald-400' : 'bg-slate-400' }} mr-2"></span>
                                            {{ $item->incoming_goods_details_count }} transaksi
                                        </span>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-actions">
                                        <x-table.action-buttons
                                            :edit-route="auth()->user()->role === 'admin_gudang' ? route('lokasi-rak.edit', $item) : null"
                                            :show-edit="auth()->user()->role === 'admin_gudang'"
                                            :delete-route="auth()->user()->role === 'admin_gudang' ? route('lokasi-rak.destroy', $item) : null"
                                            :show-delete="auth()->user()->role === 'admin_gudang'"
                                            delete-confirm="Hapus lokasi rak ini? Semua referensi akan tetap aman."
                                            container-class="justify-center"
                                        />
                                    </x-table.table-cell>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-table.table-empty title="Tidak ada lokasi rak" description="Buat lokasi baru untuk mengorganisir gudang lebih baik." :action-route="auth()->user()->role === 'admin_gudang' ? route('lokasi-rak.create') : null" action-label="Tambah Lokasi Rak" />
                @endif

                @if($lokasiRaks->count())
                    <x-table.pagination :paginator="$lokasiRaks" />
                @endif
            </x-table.table-wrapper>
        </div>

        <aside class="space-y-5 xl:col-span-1">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm h-full">
                @php
                    $topRack = $lokasiRaks->sortByDesc('incoming_goods_details_count')->first();
                    $topRackCode = $topRack?->code ?? '-';
                    $topRackTransactions = $topRack?->incoming_goods_details_count ?? 0;
                    $usageRate = $totalLocations > 0 ? round($activeRacks / $totalLocations * 100) : 0;
                @endphp

                <h3 class="text-lg font-semibold text-slate-900">Ringkasan Lokasi Rak</h3>
                <p class="mt-2 text-sm text-slate-500">Pantau kondisi penggunaan lokasi rak untuk membantu pengelolaan gudang secara lebih efektif.</p>

                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">📦 Rak Paling Aktif</p>
                        <p class="mt-3 text-lg font-semibold text-slate-900">{{ $topRackCode }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $topRackTransactions }} transaksi</p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">📭 Rak Belum Digunakan</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $unusedRacks }} Rak</p>
                        <p class="mt-1 text-sm text-slate-500">Belum pernah tercatat dalam transaksi.</p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">📊 Tingkat Penggunaan</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $usageRate }}%</p>
                        <div class="mt-4 h-2.5 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ $usageRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
