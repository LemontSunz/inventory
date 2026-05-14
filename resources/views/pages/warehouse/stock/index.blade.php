@extends('layouts.app')

@section('title', 'Kelola Stok Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Stok Barang</h2>
            <p class="mt-2 text-gray-600">Pantau dan kelola level stok barang di gudang</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Adjustment Stok
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total SKU</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">247</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Normal</p>
                    <p class="mt-2 text-2xl font-bold text-green-600">198</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Rendah</p>
                    <p class="mt-2 text-2xl font-bold text-yellow-600">37</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100">
                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Kritis</p>
                    <p class="mt-2 text-2xl font-bold text-red-600">12</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <input type="search" placeholder="Cari nama barang atau kode..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Status</option>
                    <option>Stok Normal</option>
                    <option>Stok Rendah</option>
                    <option>Stok Kritis</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Kode Barang</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Nama Barang</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Stok Saat Ini</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Min. Stok</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Max. Stok</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-001</td>
                        <td class="px-6 py-4 text-gray-600">Laptop Dell XPS 15</td>
                        <td class="px-6 py-4 text-gray-900">45</td>
                        <td class="px-6 py-4 text-gray-600">20</td>
                        <td class="px-6 py-4 text-gray-600">100</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Normal</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Adjust</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-002</td>
                        <td class="px-6 py-4 text-gray-600">Mouse Wireless Logitech</td>
                        <td class="px-6 py-4 text-gray-900">12</td>
                        <td class="px-6 py-4 text-gray-600">15</td>
                        <td class="px-6 py-4 text-gray-600">50</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Rendah</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Adjust</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-003</td>
                        <td class="px-6 py-4 text-gray-600">Keyboard Mekanik RGB</td>
                        <td class="px-6 py-4 text-gray-900">2</td>
                        <td class="px-6 py-4 text-gray-600">10</td>
                        <td class="px-6 py-4 text-gray-600">40</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Kritis</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Adjust</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">BR-004</td>
                        <td class="px-6 py-4 text-gray-600">Monitor LG 27 inch</td>
                        <td class="px-6 py-4 text-gray-900">28</td>
                        <td class="px-6 py-4 text-gray-600">15</td>
                        <td class="px-6 py-4 text-gray-600">60</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Normal</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-xs">Adjust</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">Menampilkan 1-4 dari 247 barang</p>
            <div class="flex gap-2">
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">← Sebelumnya</button>
                <button class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700">1</button>
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">2</button>
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Selanjutnya →</button>
            </div>
        </div>
    </div>
</div>
@endsection
