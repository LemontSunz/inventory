@extends('layouts.app')

@section('title', 'Kelola Data Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Flash Messages -->
    @if ($message = Session::get('success'))
        <div class="rounded-lg border border-green-300 bg-green-50 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-green-800">{{ $message }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="rounded-lg border border-red-300 bg-red-50 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-red-800">{{ $message }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Data Barang</h2>
            <p class="mt-2 text-gray-600">Kelola informasi semua barang di gudang Anda</p>
        </div>
        <a href="{{ route('barang.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Barang
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('barang.index') }}" class="space-y-4">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Barang</label>
                    <input type="search" name="search" placeholder="Cari kode barang, nama, atau kategori..." value="{{ request('search') }}" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </div>
                <div class="md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('barang.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        @if($barang->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Kode Barang</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Nama Barang</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Kategori</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Satuan</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Stok</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Lokasi Rak</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($barang as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900">{{ $barang->firstItem() + $loop->index }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $item->kode_barang }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item->nama_barang }}</p>
                                        @if($item->deskripsi)
                                            <p class="mt-1 text-xs text-gray-500">{{ Str::limit($item->deskripsi, 50) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->kategori }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->satuan }}</td>
                                <td class="px-6 py-4">
                                    @if($item->stok > 20)
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">{{ $item->stok }} unit</span>
                                    @elseif($item->stok > 5)
                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">{{ $item->stok }} unit</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">{{ $item->stok }} unit</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->lokasi_rak }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('barang.edit', $item->id) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100 transition">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold">{{ $barang->firstItem() }}</span> hingga <span class="font-semibold">{{ $barang->lastItem() }}</span> dari <span class="font-semibold">{{ $barang->total() }}</span> barang
                </p>
                <div class="flex gap-2">
                    @if($barang->onFirstPage())
                        <button disabled class="rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">← Sebelumnya</button>
                    @else
                        <a href="{{ $barang->previousPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">← Sebelumnya</a>
                    @endif

                    @foreach($barang->getUrlRange(1, $barang->lastPage()) as $page => $url)
                        @if($page == $barang->currentPage())
                            <button disabled class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($barang->hasMorePages())
                        <a href="{{ $barang->nextPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Selanjutnya →</a>
                    @else
                        <button disabled class="rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">Selanjutnya →</button>
                    @endif
                </div>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 mx-auto mb-4">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Tidak ada data barang</p>
                <p class="mt-1 text-sm text-gray-400">Mulai dengan menambahkan barang baru</p>
                <a href="{{ route('barang.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
