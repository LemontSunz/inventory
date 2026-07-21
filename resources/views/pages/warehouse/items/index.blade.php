@extends('layouts.app')

@section('title', 'Kelola Data Barang - LogistikPro')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="MANAJEMEN GUDANG"
        title="Kelola Data Barang"
        description="Kelola informasi semua barang di gudang Anda"
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('barang.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>

    <x-filter.filter-panel action="{{ route('barang.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
        <x-filter.search-input
            name="search"
            label="Cari Barang"
            value="{{ request('search') }}"
            placeholder="Cari nama barang, kode, atau deskripsi..."
        />

        <x-filter.select-input name="kategori" label="Kategori">
            <option value="">Semua Kategori</option>
            <option value="Elektronik">Elektronik</option>
            <option value="Peralatan">Peralatan</option>
            <option value="Bahan Baku">Bahan Baku</option>
        </x-filter.select-input>

        <div class="flex items-end gap-3">
            <x-filter.filter-button>Terapkan</x-filter.filter-button>
            <x-filter.reset-button :href="route('barang.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <x-table.table-wrapper title="Tabel Barang" description="Daftar barang warehouse." >
        <table class="table-standard">
            <thead>
                <tr>
                    <x-table.table-header label="Kode Barang" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Nama Barang" align="left" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Kategori" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Stok Saat Ini" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Harga" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Status" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                    <x-table.table-header label="Aksi" align="center" class="px-6 py-4 font-semibold text-gray-900" />
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <x-table.table-row>
                    <x-table.table-cell align="center" class="px-6 py-4 font-medium text-gray-900">BR-001</x-table.table-cell>
                    <x-table.table-cell align="left" class="px-6 py-4 text-gray-600">Laptop Dell XPS 15</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-600">Elektronik</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">45 unit</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-900">Rp 15.000.000</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Aktif</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <button class="text-slate-600 hover:text-slate-900 font-medium cursor-pointer">Lihat</button>
                    </x-table.table-cell>
                </x-table.table-row>
                <x-table.table-row>
                    <x-table.table-cell align="center" class="px-6 py-4 font-medium text-gray-900">BR-002</x-table.table-cell>
                    <x-table.table-cell align="left" class="px-6 py-4 text-gray-600">Mouse Wireless Logitech</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-600">Aksesoris</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">12 unit</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-900">Rp 250.000</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Stok Rendah</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <button class="text-slate-600 hover:text-slate-900 font-medium cursor-pointer">Lihat</button>
                    </x-table.table-cell>
                </x-table.table-row>
                <x-table.table-row>
                    <x-table.table-cell align="center" class="px-6 py-4 font-medium text-gray-900">BR-003</x-table.table-cell>
                    <x-table.table-cell align="left" class="px-6 py-4 text-gray-600">Keyboard Mekanik RGB</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-600">Aksesoris</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">2 unit</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-900">Rp 850.000</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Stok Kritis</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <button class="text-slate-600 hover:text-slate-900 font-medium cursor-pointer">Lihat</button>
                    </x-table.table-cell>
                </x-table.table-row>
                <x-table.table-row>
                    <x-table.table-cell align="center" class="px-6 py-4 font-medium text-gray-900">BR-004</x-table.table-cell>
                    <x-table.table-cell align="left" class="px-6 py-4 text-gray-600">Monitor LG 27 inch</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-600">Elektronik</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">28 unit</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4 text-gray-900">Rp 3.500.000</x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">Aktif</span>
                    </x-table.table-cell>
                    <x-table.table-cell align="center" class="px-6 py-4">
                        <button class="text-slate-600 hover:text-slate-900 font-medium cursor-pointer">Lihat</button>
                    </x-table.table-cell>
                </x-table.table-row>
            </tbody>
        </table>
    </x-table.table-wrapper>
</div>
@endsection
