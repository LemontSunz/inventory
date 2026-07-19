@extends('layouts.app')

@section('title', 'Barang Masuk - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">MANAJEMEN GUDANG</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Kelola Barang Masuk</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola transaksi penerimaan barang untuk memastikan pencatatan stok masuk dilakukan secara akurat.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if(auth()->user()->role === 'manager')
                <form method="GET" action="{{ route('barang-masuk.pdf') }}" class="flex gap-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('bulan'))
                        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                    @endif
                    @if(request('tahun'))
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                    @endif
                    <button type="submit" class="group inline-flex items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700 cursor-pointer">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Cetak PDF
                    </button>
                </form>
            @endif
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('barang-masuk.create') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang Masuk
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
    // Statistik (hanya UI). Pastikan field & relasi sesuai dengan model yang ada.

        $todayIncoming = App\Models\IncomingGoods::whereDate('receiving_date', now())->count();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $incomingThisMonth = App\Models\IncomingGoods::whereBetween('receiving_date', [$startOfMonth, $endOfMonth])->count();
        $totalSuppliers = App\Models\Supplier::count();
        $totalItems = App\Models\IncomingGoodsDetail::sum('quantity_received');
    @endphp


    <div class="grid w-full max-w-full gap-5 xl:grid-cols-4">
        <div class="w-full max-w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Masuk Hari Ini</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $todayIncoming }}</p>
            <p class="mt-2 text-sm text-slate-500">Total penerimaan hari ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Barang Masuk Bulan Ini</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $incomingThisMonth }}</p>
            <p class="mt-2 text-sm text-slate-500">Akumulasi transaksi bulan berjalan.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Supplier / Pengirim</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalSuppliers }}</p>
            <p class="mt-2 text-sm text-slate-500">Partner pengiriman terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Item Masuk</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $totalItems }}</p>
            <p class="mt-2 text-sm text-slate-500">Total kuantitas item masuk.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @php
            $months = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
        @endphp

        <form action="{{ route('barang-masuk.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Barang Masuk</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kode penerimaan, nama supplier, atau barang..."
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Bulan</label>
                <select name="bulan" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Semua Bulan</option>
                    @foreach($months as $num => $label)
                        <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Tahun</label>
                <select name="tahun" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Semua Tahun</option>
                    @for($year = now()->year; $year >= 2020; $year--)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    Terapkan
                </button>
                <a href="{{ route('barang-masuk.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="flex w-full max-w-full flex-col gap-5">
        <div class="w-full max-w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tabel Barang Masuk</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar transaksi barang masuk.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $incomingGoods->total() }}</div>
            </div>

            <div class="mt-6 w-full max-w-full overflow-x-auto rounded-xl">
                @if($incomingGoods->count() > 0)
                    <table class="table-standard w-full min-w-[1200px]">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="table-col-no !w-16 !min-w-[70px]">No</th>
                                <th class="table-col-code !w-[150px] !min-w-[150px]">
                                    @php
                                        $isSorted = $sort === 'receiving_code';
                                        $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                        $params = array_merge(request()->query(), ['sort' => 'receiving_code', 'direction' => $nextDirection]);
                                    @endphp
                                    <a href="{{ route('barang-masuk.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                        No. Terima
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
                                <th class="px-4 py-3 font-semibold !w-[150px] !min-w-[150px]">
                                    @php
                                        $isSorted = $sort === 'receiving_date';
                                        $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                        $params = array_merge(request()->query(), ['sort' => 'receiving_date', 'direction' => $nextDirection]);
                                    @endphp
                                    <a href="{{ route('barang-masuk.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                        Tanggal
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
                                <th class="px-4 py-3 font-semibold">
                                    @php
                                        $isSorted = $sort === 'supplier';
                                        $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                        $params = array_merge(request()->query(), ['sort' => 'supplier', 'direction' => $nextDirection]);
                                    @endphp
                                    <a href="{{ route('barang-masuk.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                        Supplier
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
                                <th class="whitespace-nowrap text-center !w-32 !min-w-[120px]">Total Item</th>
                                <th class="table-col-qty text-center !w-[90px] !min-w-[90px]">Total Qty</th>
                                <th class="table-col-actions !w-44 !min-w-[180px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($incomingGoods as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="table-col-no font-semibold text-slate-900 text-center align-middle">{{ $incomingGoods->firstItem() + $loop->index }}</td>
                                    <td class="table-col-code !w-[150px] !min-w-[150px]">{{ $item->receiving_code }}</td>
                                    <td class="table-col-date text-center align-middle !w-[150px] !min-w-[150px]">{{ $item->receiving_date->format('Y-m-d') }}</td>
                                    <td>{{ $item->supplier_name ?? $item->supplier ?? '-' }}</td>
                                    <td class="whitespace-nowrap text-center !w-32 !min-w-[120px]">{{ $item->details->count() }}</td>
                                    <td class="table-col-qty font-medium text-center align-middle !w-[90px] !min-w-[90px]" style="text-align:center">{{ $item->details->sum('quantity_received') }}</td>
                                    <td class="table-col-actions text-center align-middle !w-44 !min-w-[180px]">
                                        @if(auth()->user()->role === 'admin_gudang')
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('barang-masuk.edit', $item->id) }}" class="rounded-2xl bg-blue-50 px-3 py-2 text-[11px] font-semibold text-blue-700 hover:bg-blue-100 transition cursor-pointer">Edit</a>
                                            <form action="{{ route('barang-masuk.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer">Hapus</button>
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
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-medium">Tidak ada transaksi barang masuk</p>
                        <p class="mt-1 text-sm text-slate-400">Mulai dengan menambahkan transaksi baru</p>
                        @if(auth()->user()->role === 'admin_gudang')
                            <a href="{{ route('barang-masuk.create') }}" class="group mt-4 inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                                Tambah Barang Masuk
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $incomingGoods->firstItem() ?? 0 }}</strong> sampai <strong>{{ $incomingGoods->lastItem() ?? 0 }}</strong> dari <strong>{{ $incomingGoods->total() }}</strong> transaksi
                </div>
                @if($incomingGoods->count() > 0)
                    <div>
                        @include('partials.pagination-compact', ['paginator' => $incomingGoods])
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
