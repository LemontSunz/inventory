@extends('layouts.app')

@section('title', 'Kelola Barang Keluar - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Barang Keluar</h2>
            <p class="mt-2 text-gray-600">Kelola pengiriman dan distribusi barang keluar gudang</p>
        </div>
        <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Pengiriman Baru
        </button>
    </div>

    <!-- Stats -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Pengiriman Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">89</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Dalam Proses</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">12</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Sudah Terkirim</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">77</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Total Penerima</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">156</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <input type="search" placeholder="Cari nomor SO, customer, atau barang..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Status</option>
                    <option>Dalam Proses</option>
                    <option>Terkirim</option>
                    <option>Tiba di Tujuan</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Outbound Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">No. SO</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Customer</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Tanggal Kirim</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Jumlah Item</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Tujuan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">SO-2024-156</td>
                        <td class="px-6 py-4 text-gray-600">Toko Elektronik Maju</td>
                        <td class="px-6 py-4 text-gray-600">15 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">12 item</td>
                        <td class="px-6 py-4 text-gray-600">Jakarta Pusat</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Dalam Proses</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">SO-2024-155</td>
                        <td class="px-6 py-4 text-gray-600">Retail Store Plus</td>
                        <td class="px-6 py-4 text-gray-600">14 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">28 item</td>
                        <td class="px-6 py-4 text-gray-600">Bandung</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terkirim</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">SO-2024-154</td>
                        <td class="px-6 py-4 text-gray-600">PT. Bintang Sejahtera</td>
                        <td class="px-6 py-4 text-gray-600">13 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">45 item</td>
                        <td class="px-6 py-4 text-gray-600">Surabaya</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">Tiba di Tujuan</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">SO-2024-153</td>
                        <td class="px-6 py-4 text-gray-600">Distributor Medan</td>
                        <td class="px-6 py-4 text-gray-600">12 Juni 2024</td>
                        <td class="px-6 py-4 text-gray-600">56 item</td>
                        <td class="px-6 py-4 text-gray-600">Medan</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Terkirim</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">Menampilkan 1-4 dari 89 pengiriman</p>
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
