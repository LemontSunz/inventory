@extends('layouts.app')

@section('title', 'Laporan Stok Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Laporan Stok Barang</h2>
            <p class="mt-2 text-gray-600">Ringkasan stok berdasarkan data masuk/keluar dan level stok saat ini</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 14h12v8H6v-8z" />
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Ringkasan Laporan -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Barang</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalBarang }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100">
                    <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4 8 4 8-4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11l8 4 8-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l8 4 8-4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Stok</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalStok }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10m-16-10v10" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 17l8 4 8-4" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Barang Menipis</p>
                    <p class="mt-2 text-2xl font-bold text-yellow-700">{{ $barangMenipis }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100">
                    <svg class="h-5 w-5 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-8.1 14.04A1.5 1.5 0 004 20h16a1.5 1.5 0 001.81-2.1l-8.1-14.04a1.5 1.5 0 00-2.62 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Barang Kritis</p>
                    <p class="mt-2 text-2xl font-bold text-red-700">{{ $barangKritis }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                    <svg class="h-5 w-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86l-8.1 14.04A1.5 1.5 0 004 20h16a1.5 1.5 0 001.81-2.1l-8.1-14.04a1.5 1.5 0 00-2.62 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <form method="GET" action="{{ route('warehouse.stock.index') }}" class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Cari Kode / Nama</label>
                <input type="search" name="search" value="{{ $search }}" placeholder="Contoh: BR-001 atau nama barang..."
                    class="mt-1 w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}"
                        class="mt-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}"
                        class="mt-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Terapkan
                </button>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Kode Barang</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Nama Barang</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Stok Saat Ini</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Total Barang Masuk</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Total Barang Keluar</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Status Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($laporans as $index => $laporan)
                        @php
                            $no = $laporans->firstItem() + $index;
                            $stok = (int) ($laporan->stok_saat_ini ?? 0);
                            if ($stok > 20) {
                                $statusLabel = 'Aman';
                                $badgeClass = 'bg-green-100 text-green-700 border-green-200';
                            } elseif ($stok >= 6) {
                                $statusLabel = 'Menipis';
                                $badgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                            } else {
                                $statusLabel = 'Kritis';
                                $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $no }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $laporan->kode_barang }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $laporan->nama_barang }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ $stok }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ (int) $laporan->total_barang_masuk }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ (int) $laporan->total_barang_keluar }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $badgeClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @endforeach

                    @if($laporans->count() === 0)
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">Tidak ada data.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">Menampilkan {{ $laporans->firstItem() }}-{{ $laporans->lastItem() }} dari {{ $laporans->total() }} barang</p>
            <div>
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
