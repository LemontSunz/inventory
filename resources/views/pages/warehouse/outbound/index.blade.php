@extends('layouts.app')

@section('title', auth()->user()->role === 'manager' ? 'Laporan Barang Keluar - PT. Karya Makmur Mesindo' : 'Barang Keluar - PT. Karya Makmur Mesindo')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="MANAJEMEN GUDANG"
        title="{{ auth()->user()->role === 'manager' ? 'Laporan Barang Keluar' : 'Kelola Barang Keluar' }}"
        description="{{ auth()->user()->role === 'manager' ? 'Menampilkan laporan distribusi barang ke cabang berdasarkan data pengiriman yang tersedia.' : 'Kelola transaksi distribusi barang ke setiap cabang berdasarkan data pengiriman yang tersedia.' }}"
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'manager')
                <form method="GET" action="{{ route('warehouse.outbound.pdf') }}" class="flex gap-2">
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
                <a href="{{ route('barang-keluar.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Pengeluaran Baru
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
        $statToday = 89;
        $statOnProcess = 12;
        $statDelivered = 77;
        $statTotalBranches = 24;
    @endphp

    <div class="grid gap-4 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Keluar Hari Ini</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $statToday }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah barang keluar hari ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Proses</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $statOnProcess }}</p>
            <p class="mt-2 text-sm text-slate-500">Pengeluaran yang sedang diproses.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sudah Terkirim</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $statDelivered }}</p>
            <p class="mt-2 text-sm text-slate-500">Pengeluaran yang telah selesai.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Cabang Tujuan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $statTotalBranches }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah cabang tujuan distribusi.</p>
        </div>
    </div>

    <x-filter.filter-panel action="{{ route('barang-keluar.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
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
            label="Cari Barang Keluar"
            value="{{ request('search') }}"
            placeholder="Cari barang, cabang atau keterangan..."
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
            <x-filter.reset-button :href="route('barang-keluar.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <x-table.table-wrapper title="Tabel Barang Keluar" description="Daftar lengkap transaksi barang keluar beserta detail driver dan kendaraan." :count="$barangKeluars->total()" overflowClass="overflow-x-auto" containerClass="rounded-xl">
                @if($barangKeluars->count())
                    <table class="table-standard min-w-[1500px]">
                        <thead>
                            <tr>
                                <x-table.table-header label="No" align="center" class="outbound-col-no text-center" />
                                <x-table.table-header label="No. Pengiriman" align="center" class="outbound-col-no-pengiriman text-center" />
                                <x-table.table-header label="Tanggal" align="center" class="outbound-col-tanggal text-center" :sortable="true" sort-route="barang-keluar.index" column="tanggal_keluar" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Cabang Tujuan" align="left" class="outbound-col-cabang" />
                                <x-table.table-header label="Barang" align="left" class="outbound-col-barang" />
                                <x-table.table-header label="Jumlah" align="center" class="outbound-col-jumlah text-center" />
                                <x-table.table-header label="Pengemudi" align="left" class="outbound-col-pengemudi whitespace-nowrap" />
                                <x-table.table-header label="Kendaraan" align="left" class="outbound-col-kendaraan" />
                                <x-table.table-header label="Status" align="center" class="outbound-col-status text-center" />
                                <x-table.table-header label="Keterangan" align="left" class="outbound-col-keterangan" :sortable="true" sort-route="barang-keluar.index" column="keterangan" :current-sort="$sort" :direction="$direction" />
                                <x-table.table-header label="Aksi" align="center" class="outbound-col-aksi text-center" />
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangKeluars as $item)
                                <x-table.table-row>
                                    <x-table.table-cell align="center" class="outbound-col-no font-semibold text-slate-900">{{ $barangKeluars->firstItem() + $loop->index }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="outbound-col-no-pengiriman">{{ $item->nomor_pengiriman ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="outbound-col-tanggal">{{ optional($item->tanggal_keluar)->format('d M Y') ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="left" class="outbound-col-cabang">{{ $item->cabang->nama_cabang ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="left" class="outbound-col-barang" wrap="true">
                                        {{ $item->details->pluck('item.nama_barang')->filter()->implode(', ') ?: '-' }}
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="outbound-col-jumlah">{{ $item->details->sum('jumlah_keluar') }} unit</x-table.table-cell>
                                    <x-table.table-cell align="left" class="outbound-col-pengemudi whitespace-nowrap">{{ $item->driver->name ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="left" class="outbound-col-kendaraan whitespace-nowrap">{{ $item->kendaraan->kode_kendaraan ?? '-' }}</x-table.table-cell>
                                    <x-table.table-cell align="center" class="outbound-col-status">
                                        <div class="badge-consistent {{ $item->status === \App\Models\BarangKeluar::STATUS_TERKIRIM ? 'bg-emerald-100 text-emerald-700' : ($item->status === \App\Models\BarangKeluar::STATUS_DALAM_PERJALANAN ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700') }}">
                                            {{ $item->status }}
                                        </div>
                                    </x-table.table-cell>
                                    <x-table.table-cell align="left" class="outbound-col-keterangan" wrap="true">
                                        {{ $item->keterangan ?? '-' }}
                                    </x-table.table-cell>
                                    <x-table.table-cell align="center" class="outbound-col-aksi">
                                        <div class="inline-flex flex-nowrap items-center justify-center gap-2 whitespace-nowrap">
                                            @if($item->status === \App\Models\BarangKeluar::STATUS_DALAM_PERJALANAN && auth()->user()->role === 'admin_gudang')
                                                <form action="{{ route('barang-keluar.complete-delivery', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Selesaikan pengiriman ini?');">
                                                    @csrf
                                                    <button type="submit" class="rounded-2xl bg-sky-50 px-3 py-2 text-[11px] font-semibold text-sky-700 hover:bg-sky-100 cursor-pointer">Selesaikan Pengiriman</button>
                                                </form>
                                            @endif
                                            @if(auth()->user()->role === 'admin_gudang')
                                                <a href="{{ route('barang-keluar.cetak', $item->id) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Cetak</a>
                                                <a href="{{ route('barang-keluar.edit', $item->id) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Edit</a>
                                                <form action="{{ route('barang-keluar.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data Barang Keluar ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer">Hapus</button>
                                                </form>
                                            @else
                                                <span class="text-slate-500">Hanya lihat</span>
                                            @endif
                                        </div>
                                    </x-table.table-cell>
                                </x-table.table-row>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-table.table-empty title="Tidak ada data Barang Keluar" description="Tidak ada transaksi barang keluar untuk filter ini." />
                @endif

                @if($barangKeluars->count())
                    <x-table.pagination :paginator="$barangKeluars" />
                @endif
            </x-table.table-wrapper>
</div>
@endsection

