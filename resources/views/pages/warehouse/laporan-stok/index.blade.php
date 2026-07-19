@extends('layouts.app')

@section('title', 'Laporan Stok Barang - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">LAPORAN</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Stok Barang</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Menampilkan informasi stok barang beserta riwayat barang masuk dan barang keluar sebagai bahan pemantauan persediaan.</p>
        </div>
        @if(auth()->user()->role === 'manager')
            <form method="GET" action="{{ route('warehouse.stock.pdf') }}" class="flex gap-2">
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
    </div>

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Barang</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalBarang }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah item yang terdaftar dalam sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Stok</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalStok }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah keseluruhan stok tersedia saat ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Menipis</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $barangMenipis }}</p>
            <p class="mt-2 text-sm text-slate-500">Item yang mendekati batas stok minimum.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Kritis</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $barangKritis }}</p>
            <p class="mt-2 text-sm text-slate-500">Item yang membutuhkan perhatian segera.</p>
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

        <form method="GET" action="{{ route('warehouse.stock.index') }}" class="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Kode / Nama</label>
                <input type="search" name="search" value="{{ $search }}" placeholder="Contoh: BR-001 atau nama barang..." class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
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
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Terapkan</button>
                <a href="{{ route('warehouse.stock.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tabel Laporan Stok Barang</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar stok barang dengan status dan data masuk/keluar terbaru.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $laporans->total() }}</div>
            </div>

            <div class="mt-6 table-standard-wrapper rounded-xl">
                <table class="table-standard">
                    <colgroup>
                        <col style="width:70px" />
                        <col style="width:160px" />
                        <col style="width:420px" />
                        <col style="width:140px" />
                        <col style="width:180px" />
                        <col style="width:180px" />
                        <col style="width:140px" />
                    </colgroup>
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-col-no">No</th>
                            <th class="table-col-code">
                                @php
                                    $isSorted = $sort === 'barang.kode_barang';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'barang.kode_barang', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('warehouse.reports.stock.index', $params) }}" class="group inline-flex items-center gap-1.5 whitespace-nowrap hover:text-slate-900 transition align-middle">
                                    Kode Barang
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
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                @php
                                    $isSorted = $sort === 'barang.nama_barang';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'barang.nama_barang', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('warehouse.reports.stock.index', $params) }}" class="group inline-flex items-center gap-1.5 whitespace-nowrap hover:text-slate-900 transition align-middle">
                                    Nama Barang
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
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                @php
                                    $isSorted = $sort === 'barang.stok';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'barang.stok', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('warehouse.reports.stock.index', $params) }}" class="group inline-flex items-center gap-1.5 whitespace-nowrap hover:text-slate-900 transition align-middle">
                                    Stok Saat Ini
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
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                @php
                                    $isSorted = $sort === 'total_barang_masuk';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'total_barang_masuk', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('warehouse.reports.stock.index', $params) }}" class="group inline-flex items-center gap-1.5 whitespace-nowrap hover:text-slate-900 transition align-middle">
                                    Total Barang Masuk
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
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                @php
                                    $isSorted = $sort === 'total_barang_keluar';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'total_barang_keluar', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('warehouse.reports.stock.index', $params) }}" class="group inline-flex items-center gap-1.5 whitespace-nowrap hover:text-slate-900 transition align-middle">
                                    Total Barang Keluar
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
                            <th class="table-col-status">Status Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($laporans as $index => $laporan)
                            @php
                                $no = $laporans->firstItem() + $index;
                                $stok = (int) ($laporan->stok_saat_ini ?? 0);
                                if ($stok > 20) {
                                    $statusLabel = 'Aman';
                                    $badgeClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                } elseif ($stok >= 6) {
                                    $statusLabel = 'Menipis';
                                    $badgeClass = 'bg-amber-100 text-amber-700 border-amber-200';
                                } else {
                                    $statusLabel = 'Kritis';
                                    $badgeClass = 'bg-rose-100 text-rose-700 border-rose-200';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="table-col-no font-semibold text-slate-900">{{ $no }}</td>
                                <td class="table-col-code font-medium text-slate-900">{{ $laporan->kode_barang }}</td>
                                <td class="text-slate-600">{{ $laporan->nama_barang }}</td>
                                <td class="table-col-qty text-slate-900">{{ $stok }}</td>
                                <td class="table-col-qty text-slate-900">{{ (int) $laporan->total_barang_masuk }}</td>
                                <td class="table-col-qty text-slate-900">{{ (int) $laporan->total_barang_keluar }}</td>
                                <td class="table-col-status">
                                    <span class="badge-consistent {{ $badgeClass }}"> 
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if($laporans->count() === 0)
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-slate-500">Tidak ada data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $laporans->firstItem() }}</strong> sampai <strong>{{ $laporans->lastItem() }}</strong> dari <strong>{{ $laporans->total() }}</strong>
                </div>
                <div>{{ $laporans->links() }}</div>
            </div>
        </div>
</div>
@endsection
