@extends('layouts.app')

@section('title', 'Kelola Barang Masuk - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Barang Masuk</h2>
            <p class="mt-2 text-gray-600">Kelola penerimaan barang dari supplier</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Penerimaan Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Penerimaan Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">156</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Menunggu Verifikasi</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">8</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Sudah Diverifikasi</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">148</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Total Supplier</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">24</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <input type="search" placeholder="Cari nomor PO, supplier, atau barang..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Status</option>
                    <option>Menunggu Verifikasi</option>
                    <option>Sudah Diverifikasi</option>
                    <option>Terjadi Masalah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Inbound Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">No. PO</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Supplier</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Tanggal Terima</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Jumlah Item</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Penerima</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">PO-2024-001</td>
                        <td class="px-6 py-4 text-gray-600">PT. Maju Jaya</td>
                        <td class="px-6 py-4 text-gray-600">15 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">25 item</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">Menunggu</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">Admin</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">PO-2024-002</td>
                        <td class="px-6 py-4 text-gray-600">Distributor Indonesia</td>
                        <td class="px-6 py-4 text-gray-600">14 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">50 item</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terverifikasi</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">Budi</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">PO-2024-003</td>
                        <td class="px-6 py-4 text-gray-600">CV. Supply Center</td>
                        <td class="px-6 py-4 text-gray-600">13 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">18 item</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Masalah</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">Siti</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">PO-2024-004</td>
                        <td class="px-6 py-4 text-gray-600">PT. Global Supplier</td>
                        <td class="px-6 py-4 text-gray-600">12 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">35 item</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terverifikasi</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">Rudi</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">Menampilkan 1-4 dari 24 penerimaan</p>
            <div class="flex gap-2">
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">← Sebelumnya</button>
                <button class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700">1</button>
                <button class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Selanjutnya →</button>
            </div>
        </div>
    </div>
</div>
@endsection
