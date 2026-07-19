@extends('layouts.app')

@section('title', 'Kelola Data Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Data Barang</h2>
            <p class="mt-2 text-gray-600">Kelola informasi semua barang di gudang Anda</p>
        </div>
        <button class="group inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 cursor-pointer">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Barang
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <input type="search" placeholder="Cari nama barang, kode, atau deskripsi..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Kategori</option>
                    <option>Elektronik</option>
                    <option>Peralatan</option>
                    <option>Bahan Baku</option>
                </select>
                <button class="group inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'kode_barang';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'kode_barang', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Kode Barang
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'nama_barang';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'nama_barang', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Nama Barang
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'kategori';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'kategori', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Kategori
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'stok';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'stok', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Stok Saat Ini
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'harga';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'harga', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Harga
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">
                            @php
                                $isSorted = $sort === 'status_stok';
                                $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                $params = array_merge(request()->query(), ['sort' => 'status_stok', 'direction' => $nextDirection]);
                            @endphp
                            <a href="{{ route('barang.index', $params) }}" class="group inline-flex items-center gap-2 cursor-pointer hover:text-gray-600 transition">
                                Status
                                <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-gray-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-001</td>
                        <td class="px-6 py-4 text-gray-600">Laptop Dell XPS 15</td>
                        <td class="px-6 py-4 text-gray-600">Elektronik</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">45 unit</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">Rp 15.000.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Aktif</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-002</td>
                        <td class="px-6 py-4 text-gray-600">Mouse Wireless Logitech</td>
                        <td class="px-6 py-4 text-gray-600">Aksesoris</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">12 unit</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">Rp 250.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Stok Rendah</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-003</td>
                        <td class="px-6 py-4 text-gray-600">Keyboard Mekanik RGB</td>
                        <td class="px-6 py-4 text-gray-600">Aksesoris</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">2 unit</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">Rp 850.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Stok Kritis</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-004</td>
                        <td class="px-6 py-4 text-gray-600">Monitor LG 27 inch</td>
                        <td class="px-6 py-4 text-gray-600">Elektronik</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">28 unit</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900">Rp 3.500.000</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Aktif</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium cursor-pointer">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">Menampilkan 1-4 dari 47 barang</p>
            <div class="flex gap-2">
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">← Sebelumnya</button>
                <button class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 cursor-pointer">1</button>
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">2</button>
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer">Selanjutnya →</button>
            </div>
        </div>
    </div>
</div>
@endsection
