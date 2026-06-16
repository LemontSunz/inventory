@extends('layouts.app')

@section('title', 'Kelola Barang Masuk - LogistikPro')

@section('content')
<div class="space-y-6">
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

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Kelola Barang Masuk</h2>
            <p class="mt-2 text-gray-600">Daftar transaksi barang masuk ke gudang</p>
        </div>
        <a href="{{ route('barang-masuk.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Barang Masuk
        </a>
    </div>

    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('barang-masuk.index') }}" class="space-y-4">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <input type="search" name="search" placeholder="Cari kode penerimaan, nama supplier, atau barang..." value="{{ request('search') }}" class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">Cari</button>
                    <a href="{{ route('barang-masuk.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
        @if($incomingGoods->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">No</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">No. Terima</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Supplier</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Total Item</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Total Qty</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($incomingGoods as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900">{{ $incomingGoods->firstItem() + $loop->index }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->receiving_code }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->receiving_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $item->supplier->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item->details->count() }}</td>
                                <td class="px-6 py-4 font-medium">{{ $item->details->sum('quantity_received') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('barang-masuk.edit', $item->id) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100 transition">Edit</a>
                                        <form action="{{ route('barang-masuk.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 transition">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 border-t border-gray-200 px-6 py-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-gray-600">Menampilkan <span class="font-semibold">{{ $incomingGoods->firstItem() }}</span> hingga <span class="font-semibold">{{ $incomingGoods->lastItem() }}</span> dari <span class="font-semibold">{{ $incomingGoods->total() }}</span> transaksi</p>
                <div class="flex flex-wrap gap-2">
                    @if($incomingGoods->onFirstPage())
                        <button disabled class="rounded-lg border border-gray-300 bg-gray-100 px-3 py-2 text-sm font-medium text-gray-500 cursor-not-allowed">← Sebelumnya</button>
                    @else
                        <a href="{{ $incomingGoods->previousPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">← Sebelumnya</a>
                    @endif

                    @foreach($incomingGoods->getUrlRange(1, $incomingGoods->lastPage()) as $page => $url)
                        @if($page == $incomingGoods->currentPage())
                            <button disabled class="rounded-lg border border-blue-300 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($incomingGoods->hasMorePages())
                        <a href="{{ $incomingGoods->nextPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Selanjutnya →</a>
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
                <p class="text-gray-500 font-medium">Tidak ada transaksi barang masuk</p>
                <p class="mt-1 text-sm text-gray-400">Mulai dengan menambahkan transaksi baru</p>
                <a href="{{ route('barang-masuk.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">Tambah Barang Masuk</a>
            </div>
        @endif
    </div>
</div>
@endsection
