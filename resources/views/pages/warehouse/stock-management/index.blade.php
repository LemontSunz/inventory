@extends('layouts.app')

@section('title', 'Mengelola Stok Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Mengelola Stok Barang</h2>
            <p class="mt-2 text-gray-600">Kelola reorder point, maksimum stok, dan otomasi pembelian</p>
        </div>
        <div class="flex gap-2">
            <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Atur Reorder
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('warehouse.stock-management.index') }}">
        <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari barang (kode/nama)..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </div>
                <div class="flex gap-2">
                    <select name="status" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="semua" {{ ($status ?? 'semua') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="normal" {{ ($status ?? '') === 'normal' ? 'selected' : '' }}>Stok Normal (> 20)</option>
                        <option value="rendah" {{ ($status ?? '') === 'rendah' ? 'selected' : '' }}>Stok Rendah (6-20)</option>
                        <option value="kritis" {{ ($status ?? '') === 'kritis' ? 'selected' : '' }}>Stok Kritis (≤ 5)</option>
                    </select>

                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Terapkan
                    </button>
                </div>
            </div>
        </div>
    </form>



    <!-- Kanban Board Layout -->

    <div class="grid gap-6 lg:grid-cols-4">
        <!-- Critical Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-red-50 to-orange-50 shadow-sm border border-red-200 overflow-hidden">
            <div class="border-b border-red-200 bg-red-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-red-900">🔴 Stok Kritis</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-red-600 text-white text-xs font-bold">{{ $barangKritis }}</span>

                </div>
                <p class="mt-1 text-xs text-red-700">Segera reorder barang</p>
            </div>
            <div class="space-y-3 p-4">
                @foreach($barangs as $barang)
                    @php
                        $stok = (int) ($barang->stok ?? 0);
                        $kategoriStatus = $stok > 20 ? 'normal' : ($stok >= 6 ? 'rendah' : 'kritis');
                    @endphp

                        @if($kategoriStatus === 'kritis')


                        <div class="rounded-lg bg-white p-3 shadow-sm border border-red-200 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 text-sm">{{ $barang->nama_barang }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Kode: {{ $barang->kode_barang }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-block px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-semibold">{{ $stok }} unit</span>
                                        <span class="text-xs text-gray-500">≤ 5</span>
                                    </div>
                                </div>
                                <span class="text-red-600 font-semibold text-xs">Kritis</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <!-- Low Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-yellow-50 to-amber-50 shadow-sm border border-yellow-200 overflow-hidden">
            <div class="border-b border-yellow-200 bg-yellow-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-yellow-900">🟡 Stok Menipis</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-600 text-white text-xs font-bold">{{ $barangMenipis }}</span>

                </div>
                <p class="mt-1 text-xs text-yellow-700">Pertimbangkan untuk reorder</p>
            </div>
            <div class="space-y-3 p-4">
                @foreach($barangs as $barang)
                    @php
                        $stok = (int) ($barang->stok ?? 0);
                        $kategoriStatus = $stok > 20 ? 'normal' : ($stok >= 6 ? 'rendah' : 'kritis');
                    @endphp

                    @if($kategoriStatus === 'rendah')

                        <div class="rounded-lg bg-white p-3 shadow-sm border border-yellow-200 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 text-sm">{{ $barang->nama_barang }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Kode: {{ $barang->kode_barang }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $stok }} unit</span>
                                        <span class="text-xs text-gray-500">6 - 20</span>
                                    </div>
                                </div>
                                <span class="text-yellow-700 font-semibold text-xs">Menipis</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <!-- Normal Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 shadow-sm border border-green-200 overflow-hidden">
            <div class="border-b border-green-200 bg-green-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-green-900">🟢 Stok Aman</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-green-600 text-white text-xs font-bold">{{ $barangAman }}</span>

                </div>
                <p class="mt-1 text-xs text-green-700">Stok mencukupi</p>
            </div>
            <div class="space-y-3 p-4">
                @foreach($barangs as $barang)
                    @php
                        $stok = (int) ($barang->stok ?? 0);
                        $kategoriStatus = $stok > 20 ? 'normal' : ($stok >= 6 ? 'rendah' : 'kritis');
                    @endphp

                    @if($kategoriStatus === 'normal')

                        <div class="rounded-lg bg-white p-3 shadow-sm border border-green-200 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 text-sm">{{ $barang->nama_barang }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Kode: {{ $barang->kode_barang }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold">{{ $stok }} unit</span>
                                        <span class="text-xs text-gray-500">> 20</span>
                                    </div>
                                </div>
                                <span class="text-green-700 font-semibold text-xs">Aman</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <!-- Overstocked Column -->
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 shadow-sm border border-blue-200 overflow-hidden">
            <div class="border-b border-blue-200 bg-blue-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-blue-900">📦 Daftar Stok</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-600 text-white text-xs font-bold">{{ $totalBarang }}</span>

                </div>
                <p class="mt-1 text-xs text-blue-700">Stok melebihi maksimum</p>
            </div>
            <div class="space-y-3 p-4">
                @foreach($barangs as $barang)
                    @php
                        $stok = (int) ($barang->stok ?? 0);
                        $kategoriStatus = $stok > 20 ? 'normal' : ($stok >= 6 ? 'rendah' : 'kritis');
                    @endphp


                    @if(in_array($kategoriStatus, ['aman','menipis','kritis'], true))
                        <div class="rounded-lg bg-white p-3 shadow-sm border border-blue-200 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 text-sm">{{ $barang->nama_barang }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Kode: {{ $barang->kode_barang }}</p>
                                    <div class="mt-2 flex items-center gap-2">
                                        @if($kategoriStatus === 'aman')
                                            <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold">{{ $stok }} unit</span>
                                            <span class="text-xs text-gray-500">Aman</span>
                                        @elseif($kategoriStatus === 'menipis')
                                            <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">{{ $stok }} unit</span>
                                            <span class="text-xs text-gray-500">Menipis</span>
                                        @else
                                            <span class="inline-block px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-semibold">{{ $stok }} unit</span>
                                            <span class="text-xs text-gray-500">Kritis</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-blue-700 font-semibold text-xs">{{ $kategoriStatus }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </div>

    <!-- Pagination -->
    @include('pages.warehouse.stock-management._debug_pagination')
    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
        <p class="text-sm text-gray-600">Menampilkan {{ $barangs->firstItem() }}-{{ $barangs->lastItem() }} dari {{ $barangs->total() }} barang</p>
        <div>
            {{ $barangs->links() }}
        </div>
    </div>

</div>
@endsection
