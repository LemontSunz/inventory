@extends('layouts.app')

@section('title', 'Kelola Barang Keluar - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">MANAJEMEN GUDANG</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Kelola Barang Keluar</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola transaksi distribusi barang ke setiap cabang berdasarkan data pengiriman yang tersedia.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if(auth()->user()->role === 'manager')
                <form method="GET" action="{{ route('warehouse.outbound.pdf') }}" class="flex gap-2">
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
                <a href="{{ route('barang-keluar.create') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Pengeluaran Baru</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $statToday = 89;
        $statOnProcess = 12;
        $statDelivered = 77;
        $statTotalBranches = 24;
    @endphp

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Barang Keluar Hari Ini</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $statToday }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah barang keluar hari ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Proses</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $statOnProcess }}</p>
            <p class="mt-2 text-sm text-slate-500">Pengeluaran yang sedang diproses.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sudah Terkirim</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $statDelivered }}</p>
            <p class="mt-2 text-sm text-slate-500">Pengeluaran yang telah selesai.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Cabang Tujuan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $statTotalBranches }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah cabang tujuan distribusi.</p>
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

        <form action="{{ route('barang-keluar.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1.5fr_0.85fr_0.85fr_1fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Barang Keluar</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari barang, cabang atau keterangan..." class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
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
                <a href="{{ route('barang-keluar.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tabel Barang Keluar</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar lengkap transaksi barang keluar beserta detail driver dan kendaraan.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $barangKeluars->total() }}</div>
            </div>

            <div class="mt-6 rounded-xl">
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="table-standard min-w-[1500px]">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="outbound-col-no text-center">No</th>
                            <th class="outbound-col-no-pengiriman text-center">No. Pengiriman</th>
                            <th class="outbound-col-tanggal text-center">
                                @php
                                    $isSorted = $sort === 'tanggal_keluar';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'tanggal_keluar', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('barang-keluar.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
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
                            <th class="outbound-col-cabang">Cabang Tujuan</th>
                            <th class="outbound-col-barang">Barang</th>
                            <th class="outbound-col-jumlah text-center">Jumlah</th>
                            <th class="outbound-col-pengemudi whitespace-nowrap">Pengemudi</th>
                            <th class="outbound-col-kendaraan whitespace-nowrap text-center">Kendaraan</th>
                            <th class="outbound-col-status text-center">Status</th>
                            <th class="outbound-col-keterangan">
                                @php
                                    $isSorted = $sort === 'keterangan';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'keterangan', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('barang-keluar.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Keterangan
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
                            <th class="outbound-col-aksi text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($barangKeluars as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="outbound-col-no text-center align-middle font-semibold text-slate-900">{{ $barangKeluars->firstItem() + $loop->index }}</td>
                                <td class="outbound-col-no-pengiriman align-middle text-center">{{ $item->nomor_pengiriman ?? '-' }}</td>
                                <td class="outbound-col-tanggal align-middle text-center">{{ optional($item->tanggal_keluar)->format('d M Y') ?? '-' }}</td>
                                <td class="outbound-col-cabang align-middle">{{ $item->cabang->nama_cabang ?? '-' }}</td>
                                <td class="outbound-col-barang align-middle leading-6">
                                    <div class="max-w-full whitespace-normal break-words">{{ $item->details->pluck('item.nama_barang')->filter()->implode(', ') ?: '-' }}</div>
                                </td>
                                <td class="outbound-col-jumlah align-middle text-center">{{ $item->details->sum('jumlah_keluar') }} unit</td>
                                <td class="outbound-col-pengemudi align-middle whitespace-nowrap">{{ $item->driver->name ?? '-' }}</td>
                                <td class="outbound-col-kendaraan align-middle whitespace-nowrap text-center">{{ $item->kendaraan->kode_kendaraan ?? '-' }}</td>
                                <td class="outbound-col-status align-middle text-center">
                                    <div class="badge-consistent {{ $item->status === \App\Models\BarangKeluar::STATUS_TERKIRIM ? 'bg-emerald-100 text-emerald-700' : ($item->status === \App\Models\BarangKeluar::STATUS_DALAM_PERJALANAN ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td class="outbound-col-keterangan align-middle leading-6">
                                    <div class="max-w-full whitespace-normal break-words">{{ $item->keterangan ?? '-' }}</div>
                                </td>
                                <td class="outbound-col-aksi align-middle text-center">
                                    <div class="inline-flex flex-nowrap items-center justify-center gap-2 whitespace-nowrap">
                                        @if($item->status === \App\Models\BarangKeluar::STATUS_DALAM_PERJALANAN && auth()->user()->role === 'admin_gudang')
                                            <form action="{{ route('barang-keluar.complete-delivery', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Selesaikan pengiriman ini?');">
                                                @csrf
                                                <button type="submit" class="rounded-2xl bg-sky-50 px-3 py-2 text-[11px] font-semibold text-sky-700 hover:bg-sky-100 cursor-pointer">Selesaikan Pengiriman</button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->role === 'admin_gudang')
                                            <a href="{{ route('barang-keluar.cetak', $item->id) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Cetak</a>
                                            <a href="{{ route('barang-keluar.edit', $item->id) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Edit</a>
                                            <form action="{{ route('barang-keluar.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data Barang Keluar ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-slate-500">Hanya lihat</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-16 text-center text-slate-500">Tidak ada data Barang Keluar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $barangKeluars->firstItem() ?? 0 }}</strong> sampai <strong>{{ $barangKeluars->lastItem() ?? 0 }}</strong> dari <strong>{{ $barangKeluars->total() }}</strong>
                </div>
                <div>
                    @include('partials.pagination-compact', ['paginator' => $barangKeluars])
                </div>
            </div>
        </div>
    </div>
@endsection

