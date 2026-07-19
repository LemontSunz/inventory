@extends('layouts.app')

@section('title', 'Data Barang - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Manajemen Gudang</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Kelola Data Barang</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola data barang yang tersimpan di gudang untuk mendukung pengelolaan stok secara akurat.</p>
        </div>
        @if(auth()->user()->role === 'admin_gudang')
            <a href="{{ route('barang.create') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Barang
            </a>
        @endif
    </div>



    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('barang.index') }}" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.9fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Barang</label>
                <input type="search" name="search" placeholder="Cari kode barang, nama, atau kategori..." value="{{ request('search') }}" 
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Kategori</label>
                <select name="kategori" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    Cari
                </button>
                <a href="{{ route('barang.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @if($barang->count() > 0)
            <div class="w-full overflow-hidden rounded-xl border border-slate-200">
                <table class="table-data-barang w-full border-collapse">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="w-[5%] min-w-[56px] text-center">No</th>
                            <th class="w-[12%] min-w-[110px] text-center">Kode Barang</th>
                            <th class="w-[40%] min-w-[220px] text-center">Nama Barang</th>
                            <th class="w-[23%] min-w-[140px] text-center">Kategori</th>
                            <th class="w-[8%] min-w-[90px] text-center">Satuan</th>
                            <th class="w-[12%] min-w-[160px] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($barang as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="text-center align-middle font-semibold text-slate-900">{{ $barang->firstItem() + $loop->index }}</td>
                                <td class="text-center align-middle">
                                    <span class="table-badge">{{ $item->kode_barang }}</span>
                                </td>
                                <td class="text-left align-middle">
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $item->nama_barang }}</p>
                                        @if($item->deskripsi)
                                            <p class="mt-1 text-xs leading-5 text-slate-500">{{ Str::limit($item->deskripsi, 80) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap text-center align-middle text-slate-600">{{ $item->kategori }}</td>
                                <td class="whitespace-nowrap text-center align-middle text-slate-600">{{ $item->satuan }}</td>
                                <td class="text-center align-middle">
                                    @if(auth()->user()->role === 'admin_gudang')
                                        <div class="inline-flex flex-nowrap items-center justify-center gap-2 whitespace-nowrap">
                                            <a href="{{ route('barang.edit', $item->id) }}" class="rounded-2xl bg-blue-50 px-3 py-2 text-[11px] font-semibold leading-none text-blue-700 transition hover:bg-blue-100 cursor-pointer">Edit</a>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data barang ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold leading-none text-rose-700 transition hover:bg-rose-100 cursor-pointer">Hapus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-slate-500">Hanya lihat</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600 border-t border-slate-200 pt-4">
                <div>
                    Menampilkan <strong>{{ $barang->firstItem() }}</strong> hingga <strong>{{ $barang->lastItem() }}</strong> dari <strong>{{ $barang->total() }}</strong> barang
                </div>
                <div>
                    @include('partials.pagination-compact', ['paginator' => $barang])
                </div>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 mx-auto mb-4">
                    <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">Tidak ada data barang</p>
                <p class="mt-1 text-sm text-slate-400">Mulai dengan menambahkan barang baru</p>
                @if(auth()->user()->role === 'admin_gudang')
                    <a href="{{ route('barang.create') }}" class="group mt-4 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                        Tambah Barang Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>

</div>
@endsection
