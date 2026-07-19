@extends('layouts.app')

@section('title', 'Data Cabang - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">MANAJEMEN GUDANG</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Kelola Data Cabang</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola data cabang sebagai tujuan distribusi barang dalam operasional logistik perusahaan.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('cabang.create') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Cabang
                </a>
            @endif
        </div>
    </div>

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

    @php
        // Statistik aman berdasarkan kolom pada tabel cabang:
        // kode_cabang, nama_cabang, kota, alamat
        $totalCabang = App\Models\Cabang::count();
        $totalKota = App\Models\Cabang::select('kota')->distinct()->count();
        $totalNamaCabang = App\Models\Cabang::select('nama_cabang')->distinct()->count();
        $totalAlamat = App\Models\Cabang::select('alamat')->distinct()->count();
    @endphp

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Cabang</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalCabang }}</p>
            <p class="mt-2 text-sm text-slate-500">Cabang terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Kota</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $totalKota }}</p>
            <p class="mt-2 text-sm text-slate-500">Unit tersebar per kota.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Nama Cabang</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalNamaCabang }}</p>
            <p class="mt-2 text-sm text-slate-500">Variasi nama cabang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Alamat</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $totalAlamat }}</p>
            <p class="mt-2 text-sm text-slate-500">Lokasi alamat unik.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('cabang.index') }}" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Cabang</label>
                <input type="search" name="search" placeholder="Cari kode cabang, nama, atau kota..." value="{{ request('search') }}"
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
            <div class="hidden lg:block"></div>
            <div class="flex items-end gap-3">
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Cari</button>
                <a href="{{ route('cabang.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @if($cabangs->count() > 0)
            <div class="table-standard-wrapper rounded-xl overflow-x-hidden">
                <table class="table-standard w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-col-no px-3 py-3 text-center align-middle">No</th>
                            <th class="table-col-code px-3 py-3 text-center align-middle">
                                @php
                                    $isSorted = $sort === 'kode_cabang';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'kode_cabang', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('cabang.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Kode Cabang
                                    <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-left align-middle">
                                @php
                                    $isSorted = $sort === 'nama_cabang';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'nama_cabang', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('cabang.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Nama Cabang
                                    <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-center align-middle">
                                @php
                                    $isSorted = $sort === 'kota';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'kota', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('cabang.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Kota
                                    <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-left align-middle">
                                @php
                                    $isSorted = $sort === 'alamat';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'alamat', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('cabang.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Alamat
                                    <span class="inline-flex items-center">
                                        @if($isSorted)
                                            @if($direction === 'asc')
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 15.21a.75.75 0 001.06.02L12 10.56l5.71 4.67a.75.75 0 001.06-1.06l-6.24-5.11a.75.75 0 00-1.06 0L5.23 14.15a.75.75 0 00.02 1.06z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="h-4 w-4 text-slate-900 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                            @endif
                                        @else
                                            <svg class="h-4 w-4 text-slate-400 opacity-0 group-hover:opacity-100 transition-opacity duration-150 ease-in-out" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M18.77 8.79a.75.75 0 00-1.06-.02L12 14.94 6.29 8.23a.75.75 0 00-1.06 1.06l6.24 6.25a.75.75 0 001.06 0l6.24-6.25a.75.75 0 00-.02-1.06z" clip-rule="evenodd"/></svg>
                                        @endif
                                    </span>
                                </a>
                            </th>
                            <th class="table-col-actions px-3 py-3 text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($cabangs as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="table-col-no px-3 py-3 align-middle">
                                    <div class="flex items-center justify-center">
                                        <span class="font-semibold text-slate-900">{{ $cabangs->firstItem() + $loop->index }}</span>
                                    </div>
                                </td>
                                <td class="table-col-code px-3 py-3 align-middle">
                                    <div class="flex items-center justify-center">
                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $item->kode_cabang }}</span>
                                    </div>
                                </td>
                                <td class="text-left align-middle">
                                    <p class="font-medium text-slate-900">{{ $item->nama_cabang }}</p>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 align-middle text-slate-600">
                                    <div class="flex items-center justify-center">
                                        {{ $item->kota }}
                                    </div>
                                </td>
                                <td class="text-left align-middle text-slate-600 break-words whitespace-normal" style="max-width:60ch">{{ $item->alamat }}</td>
                                <td class="table-col-actions px-3 py-3 text-center align-middle">
                                    <div class="inline-flex flex-wrap justify-center gap-2">
                                        @if(auth()->user()->role === 'admin_gudang')
                                            <a href="{{ route('cabang.edit', $item->id) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Edit</a>
                                            <form action="{{ route('cabang.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data cabang ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-slate-500">Hanya lihat</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $cabangs->firstItem() }}</strong> hingga <strong>{{ $cabangs->lastItem() }}</strong> dari <strong>{{ $cabangs->total() }}</strong> cabang
                </div>
                <div>
                    @include('partials.pagination-compact', ['paginator' => $cabangs])
                </div>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 mx-auto mb-4">
                    <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">Tidak ada data cabang</p>
                <p class="mt-1 text-sm text-slate-400">Mulai dengan menambahkan cabang baru</p>
                <a href="{{ route('cabang.create') }}" class="group mt-4 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    Tambah Cabang Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection


