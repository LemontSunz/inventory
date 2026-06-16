@extends('layouts.app')

@section('title', 'Kelola Barang Keluar - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Barang Keluar</h2>
            <p class="mt-2 text-gray-600">Kelola distribusi dan pengeluaran barang dari gudang</p>
        </div>
        <a href="{{ route('barang-keluar.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Pengeluaran Baru
        </a>

    </div>

    <!-- Stats -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
            <p class="text-sm text-gray-600">Barang Keluar Hari Ini</p>
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
            <p class="text-sm text-gray-600">Total Cabang Tujuan</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">24</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <form method="GET" action="{{ route('barang-keluar.index') }}" class="w-full">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari barang, cabang tujuan, atau keterangan..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </form>
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" disabled>
                    <option>Semua Status</option>
                    <option>Dalam Proses</option>
                    <option>Terkirim</option>
                    <option>Batal</option>
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
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Barang</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Cabang Tujuan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Driver</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Kendaraan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Jumlah Keluar</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Keterangan</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi Edit</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi Hapus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($barangKeluars as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $barangKeluars->firstItem() + $loop->index }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->cabang->nama_cabang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->driver->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->kendaraan->kode_kendaraan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->jumlah_keluar }} unit</td>
                            <td class="px-6 py-4 text-gray-600">{{ optional($item->tanggal_keluar)->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('barang-keluar.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('barang-keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data Barang Keluar ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cursor-pointer text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-gray-500" colspan="8">Tidak ada data Barang Keluar.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold">{{ $barangKeluars->firstItem() }}</span> hingga <span class="font-semibold">{{ $barangKeluars->lastItem() }}</span> dari <span class="font-semibold">{{ $barangKeluars->total() }}</span> barang keluar
            </p>
            <div class="flex gap-2">
                @if($barangKeluars->onFirstPage())
                    <button disabled class="rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">← Sebelumnya</button>
                @else
                    <a href="{{ $barangKeluars->previousPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">← Sebelumnya</a>
                @endif

                @foreach($barangKeluars->getUrlRange(1, $barangKeluars->lastPage()) as $page => $url)
                    @if($page == $barangKeluars->currentPage())
                        <button disabled class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($barangKeluars->hasMorePages())
                    <a href="{{ $barangKeluars->nextPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Selanjutnya →</a>
                @else
                    <button disabled class="rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Selanjutnya →</button>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

