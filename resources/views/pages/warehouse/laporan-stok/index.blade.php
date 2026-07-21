@extends('layouts.app')

@section('title', 'Laporan Stok Barang - LogistikPro')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="LAPORAN"
        title="Stok Barang"
        description="Menampilkan informasi stok barang beserta riwayat barang masuk dan barang keluar sebagai bahan pemantauan persediaan."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'manager')
                <form method="GET" action="{{ route('warehouse.stock.pdf') }}" class="flex gap-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('bulan'))
                        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                    @endif
                    @if(request('tahun'))
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                    @endif
                    <button type="submit" class="group inline-flex items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 cursor-pointer">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Cetak PDF
                    </button>
                </form>
            @endif
        </x-slot:actionButton>
    </x-page-header>

    <div class="grid gap-4 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Barang</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalBarang }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah item yang terdaftar dalam sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Stok</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalStok }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah keseluruhan stok tersedia saat ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Menipis</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $barangMenipis }}</p>
            <p class="mt-2 text-sm text-slate-500">Item yang mendekati batas stok minimum.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Kritis</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $barangKritis }}</p>
            <p class="mt-2 text-sm text-slate-500">Item yang membutuhkan perhatian segera.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('warehouse.stock.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
        @php
            $months = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
        @endphp

        <x-filter.search-input
            name="search"
            label="Cari Kode / Nama"
            value="{{ $search }}"
            placeholder="Contoh: BR-001 atau nama barang..."
        />

        <x-filter.select-input name="bulan" label="Bulan">
            <option value="">Semua Bulan</option>
            @foreach($months as $num => $label)
                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </x-filter.select-input>

        <x-filter.select-input name="tahun" label="Tahun">
            <option value="">Semua Tahun</option>
            @for($year = now()->year; $year >= 2020; $year--)
                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endfor
        </x-filter.select-input>

        <div class="flex items-end gap-3">
            <x-filter.filter-button>Terapkan</x-filter.filter-button>
            <x-filter.reset-button :href="route('warehouse.stock.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <x-table.table-wrapper title="Tabel Laporan Stok Barang" description="Daftar stok barang dengan status dan data masuk/keluar terbaru." :count="$laporans->total()" overflowClass="overflow-x-auto" containerClass="rounded-xl">
                @if($laporans->count())
                    <table class="table-standard">
                        <colgroup>
                            <col style="width:70px" />
                            <col style="width:160px" />
                            <col style="width:420px" />
                            <col style="width:140px" />
                            <col style="width:180px" />
                            <col style="width:180px" />
                            <col style="width:140px" />
                        </colgroup>
                        <thead>
                            <tr>
                                <x-table.table-header label="No" align="center" class="table-col-no" />
                                <x-table.table-header label="Kode Barang" align="center" class="table-col-code" :sortable="true" sort-route="warehouse.reports.stock.index" column="barang.kode_barang" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Nama Barang" align="left" class="px-4 py-3 font-semibold whitespace-nowrap" :sortable="true" sort-route="warehouse.reports.stock.index" column="barang.nama_barang" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Stok Saat Ini" align="center" class="px-4 py-3 font-semibold whitespace-nowrap" :sortable="true" sort-route="warehouse.reports.stock.index" column="barang.stok" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Total Barang Masuk" align="center" class="px-4 py-3 font-semibold whitespace-nowrap" :sortable="true" sort-route="warehouse.reports.stock.index" column="total_barang_masuk" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Total Barang Keluar" align="center" class="px-4 py-3 font-semibold whitespace-nowrap" :sortable="true" sort-route="warehouse.reports.stock.index" column="total_barang_keluar" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Status Stok" align="center" class="table-col-status" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $index => $laporan)
                                @php
                                    $no = $laporans->firstItem() + $index;
                                    $stok = (int) ($laporan->stok_saat_ini ?? 0);
                                    if ($stok > 20) {
                                        $statusLabel = 'Aman';
                                        $badgeClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                    } elseif ($stok >= 6) {
                                        $statusLabel = 'Menipis';
                                        $badgeClass = 'bg-amber-100 text-amber-700 border-amber-200';
                                    } else {
                                        $statusLabel = 'Kritis';
                                        $badgeClass = 'bg-rose-100 text-rose-700 border-rose-200';
                                    }
                                @endphp
                                <x-table.table-row>
                                    <x-table.table-cell align="center" class="table-col-no font-semibold text-slate-900">{{ $no }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-code font-medium text-slate-900">{{ $laporan->kode_barang }}</x-table.table-cell>
                                    <x-table.table-cell align="left" class="text-slate-600">{{ $laporan->nama_barang }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-qty text-slate-900">{{ $stok }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-qty text-slate-900">{{ (int) $laporan->total_barang_masuk }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-qty text-slate-900">{{ (int) $laporan->total_barang_keluar }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="table-col-status">
                                        <span class="badge-consistent {{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </x-table.table-cell>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-table.table-empty title="Tidak ada data" description="Tidak ada laporan stok untuk filter ini." />
                @endif

                @if($laporans->count())
                    <x-table.pagination :paginator="$laporans" />
                @endif
            </x-table.table-wrapper>
</div>
@endsection
