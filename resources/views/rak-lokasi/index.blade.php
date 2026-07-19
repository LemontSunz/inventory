@extends('layouts.app')

@section('title', 'Lokasi Rak - LogistikPro')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">GUDANG</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Kelola Lokasi Rak</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola lokasi penyimpanan barang di gudang agar proses pencarian dan penataan barang lebih efisien.</p>
        </div>
        @if(auth()->user()->role === 'admin_gudang')
            <a href="{{ route('lokasi-rak.create') }}" class="group inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lokasi Rak
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Lokasi</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalLocations }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah lokasi rak yang terdaftar.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Aktif</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $activeRacks }}</p>
            <p class="mt-2 text-sm text-slate-500">Rak yang sedang digunakan.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Belum Digunakan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $unusedRacks }}</p>
            <p class="mt-2 text-sm text-slate-500">Rak yang belum terisi transaksi.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Terakhir Diperbarui</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ optional($lastUpdated)->format('d M Y') ?? '-' }}</p>
            <p class="mt-2 text-sm text-slate-500">Tanggal pembaruan data lokasi rak terakhir.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('lokasi-rak.index') }}" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Lokasi Rak</label>
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari kode atau label..." class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
            <div class="hidden lg:block"></div>
            <div class="flex items-end gap-3">
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Cari</button>
                <a href="{{ route('lokasi-rak.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%] rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Daftar Lokasi Rak</h2>
                    <p class="mt-1 text-sm text-slate-500">Kelola rak berdasarkan kode, label, dan status penggunaan.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $lokasiRaks->total() }}</div>
            </div>

            <div class="mt-6 table-standard-wrapper">
                <table class="table-standard">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-col-no">No</th>
                            <th class="table-col-code">Kode Rak</th>
                            <th>Label</th>
                            <th>Deskripsi</th>
                            <th class="whitespace-nowrap">Penggunaan</th>
                            <th class="table-col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($lokasiRaks as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="table-col-no font-medium text-slate-900">{{ $lokasiRaks->firstItem() + $loop->index }}</td>
                                <td class="table-col-code">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700">{{ $item->code }}</span>
                                </td>
                                <td class="">{{ $item->label ?? '-' }}</td>
                                <td class="text-slate-500">{{ \Illuminate\Support\Str::limit($item->description ?? '-', 120) }}</td>
                                <td class="whitespace-nowrap">
                                    <span class="badge-consistent bg-slate-100 text-slate-700">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $item->incoming_goods_details_count ? 'bg-emerald-400' : 'bg-slate-400' }} mr-2"></span>
                                        {{ $item->incoming_goods_details_count }} transaksi
                                    </span>
                                </td>
                                <td class="table-col-actions">
                                    <div class="flex flex-wrap gap-2">
                                        @if(auth()->user()->role === 'admin_gudang')
                                            <a href="{{ route('lokasi-rak.edit', $item) }}" class="group inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-slate-50 cursor-pointer">Edit</a>
                                            <form action="{{ route('lokasi-rak.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus lokasi rak ini? Semua referensi akan tetap aman.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="group inline-flex items-center gap-2 rounded-2xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100 cursor-pointer">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-slate-500">Hanya lihat</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">Tidak ada lokasi rak. Buat lokasi baru untuk mengorganisir gudang lebih baik.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-sm text-slate-600">
                <p>Menampilkan {{ $lokasiRaks->firstItem() ?? 0 }} sampai {{ $lokasiRaks->lastItem() ?? 0 }} dari {{ $lokasiRaks->total() }} lokasi rak</p>
                <div class="flex flex-wrap gap-2">{{ $lokasiRaks->links() }}</div>
            </div>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Ringkasan Lokasi Rak</h3>
                <p class="mt-2 text-sm text-slate-500">Pantau status lokasi rak dan gunakan metrik ini untuk perencanaan ruang gudang.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Total Lokasi</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalLocations }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Aktif</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $activeRacks }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Rak Belum Digunakan</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $unusedRacks }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Terakhir Diperbarui</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ optional($lastUpdated)->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
