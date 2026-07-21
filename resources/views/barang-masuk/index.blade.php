@extends('layouts.app')

@section('title', 'Barang Masuk - LogistikPro')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="MANAJEMEN GUDANG"
        title="Kelola Barang Masuk"
        description="Kelola transaksi penerimaan barang untuk memastikan pencatatan stok masuk dilakukan secara akurat."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'manager')
                <form method="GET" action="{{ route('barang-masuk.pdf') }}" class="flex gap-2">
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
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('barang-masuk.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang Masuk
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

@php
    // Statistik (hanya UI). Pastikan field & relasi sesuai dengan model yang ada.

        $todayIncoming = App\Models\IncomingGoods::whereDate('receiving_date', now())->count();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $incomingThisMonth = App\Models\IncomingGoods::whereBetween('receiving_date', [$startOfMonth, $endOfMonth])->count();
        $totalSuppliers = App\Models\Supplier::count();
        $totalItems = App\Models\IncomingGoodsDetail::sum('quantity_received');
    @endphp


    <div class="grid w-full max-w-full gap-4 xl:grid-cols-4">
        <div class="w-full max-w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Masuk Hari Ini</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $todayIncoming }}</p>
            <p class="mt-2 text-sm text-slate-500">Total penerimaan hari ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Barang Masuk Bulan Ini</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $incomingThisMonth }}</p>
            <p class="mt-2 text-sm text-slate-500">Akumulasi transaksi bulan berjalan.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Supplier / Pengirim</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalSuppliers }}</p>
            <p class="mt-2 text-sm text-slate-500">Partner pengiriman terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Item Masuk</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $totalItems }}</p>
            <p class="mt-2 text-sm text-slate-500">Total kuantitas item masuk.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('barang-masuk.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
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
            label="Cari Barang Masuk"
            value="{{ request('search') }}"
            placeholder="Cari kode penerimaan, nama supplier, atau barang..."
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
            <x-filter.reset-button :href="route('barang-masuk.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <div class="flex w-full max-w-full flex-col gap-5">
        <x-table.table-wrapper title="Tabel Barang Masuk" description="Daftar transaksi barang masuk." :count="$incomingGoods->total()">
            @if($incomingGoods->count() > 0)
                <table class="table-standard">
                    <thead>
                        <tr>
                            <x-table.table-header label="No" align="center" class="w-[5%] min-w-[70px]" />
                            <x-table.table-header label="No. Terima" align="center" class="w-[12%] min-w-[150px]" :sortable="true" sort-route="barang-masuk.index" column="receiving_code" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Tanggal" align="center" class="w-[12%] min-w-[150px]" :sortable="true" sort-route="barang-masuk.index" column="receiving_date" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Supplier" align="left" class="w-[28%] min-w-[220px]" :sortable="true" sort-route="barang-masuk.index" column="supplier" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Total Item" align="center" class="w-[10%] min-w-[120px]" />
                            <x-table.table-header label="Total Qty" align="center" class="w-[10%] min-w-[90px]" />
                            <x-table.table-header label="Aksi" align="center" class="w-[18%] min-w-[180px]" />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomingGoods as $item)
                            <x-table.table-row>
                                <x-table.table-cell align="center" class="font-semibold text-slate-900">{{ $incomingGoods->firstItem() + $loop->index }}</x-table.table-cell>
                                <x-table.table-cell align="center">{{ $item->receiving_code }}</x-table.table-cell>
                                <x-table.table-cell align="center">{{ $item->receiving_date->format('Y-m-d') }}</x-table.table-cell>
                                <x-table.table-cell align="left">{{ $item->supplier_name ?? $item->supplier ?? '-' }}</x-table.table-cell>
                                <x-table.table-cell align="center">{{ $item->details->count() }}</x-table.table-cell>
                                <x-table.table-cell align="center" class="font-medium text-slate-900">{{ $item->details->sum('quantity_received') }}</x-table.table-cell>
                                <x-table.table-cell align="center">
                                    @if(auth()->user()->role === 'admin_gudang')
                                        <x-table.action-buttons :edit-route="route('barang-masuk.edit', $item->id)" :delete-route="route('barang-masuk.destroy', $item->id)" delete-confirm="Apakah Anda yakin ingin menghapus transaksi ini?" />
                                    @else
                                        <span class="text-slate-500">Hanya lihat</span>
                                    @endif
                                </x-table.table-cell>
                            </x-table.table-row>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-table.table-empty title="Tidak ada transaksi barang masuk" description="Mulai dengan menambahkan transaksi baru" :action-route="auth()->user()->role === 'admin_gudang' ? route('barang-masuk.create') : null" action-label="Tambah Barang Masuk" />
            @endif

            @if($incomingGoods->count() > 0)
                <x-table.pagination :paginator="$incomingGoods" />
            @endif
        </x-table.table-wrapper>
    </div>
</div>
@endsection
