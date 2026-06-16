@extends('layouts.app')

@section('title', 'Lokasi Rak - LogistikPro')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Gudang</p>
            <h2 class="text-3xl font-bold text-slate-950">Lokasi Rak</h2>
            <p class="mt-2 text-sm text-slate-600">Kelola ruang penyimpanan fisik dan organisasi rak secara sistematis.</p>
        </div>
        <a href="{{ route('lokasi-rak.create') }}" class="inline-flex items-center gap-2 rounded-3xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Lokasi Rak
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[1.5fr_1fr]">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Lokasi Rak</h3>
                    <p class="mt-1 text-sm text-slate-500">Kelola rak berdasarkan kode, label, dan status penggunaan.</p>
                </div>
                <form method="GET" action="{{ route('lokasi-rak.index') }}" class="flex w-full gap-3 sm:w-auto">
                    <label class="sr-only">Cari</label>
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari kode atau label" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-100" />
                    <button type="submit" class="rounded-2xl bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Cari</button>
                </form>
            </div>

            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-slate-700">
                        <thead class="border-b border-slate-200 bg-slate-50 text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <tr>
                                <th class="px-5 py-4">No</th>
                                <th class="px-5 py-4">Kode Rak</th>
                                <th class="px-5 py-4">Label</th>
                                <th class="px-5 py-4">Deskripsi</th>
                                <th class="px-5 py-4">Penggunaan</th>
                                <th class="px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($lokasiRaks as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4 font-medium text-slate-900">{{ $lokasiRaks->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700">{{ $item->code }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-slate-900">{{ $item->label ?? '-' }}</td>
                                    <td class="px-5 py-4 text-slate-500">{{ \Illuminate\Support\Str::limit($item->description ?? '-', 80) }}</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $item->incoming_goods_details_count ? 'bg-emerald-400' : 'bg-slate-400' }}"></span>
                                            {{ $item->incoming_goods_details_count }} transaksi
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('lokasi-rak.edit', $item->id) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-900 transition hover:bg-slate-50">Edit</a>
                                            <form action="{{ route('lokasi-rak.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus lokasi rak ini? Semua referensi akan tetap aman.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">Hapus</button>
                                            </form>
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
            </div>

            <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">Menampilkan {{ $lokasiRaks->firstItem() ?? 0 }} sampai {{ $lokasiRaks->lastItem() ?? 0 }} dari {{ $lokasiRaks->total() }} lokasi rak</p>
                <div class="flex flex-wrap gap-2">
                    {{ $lokasiRaks->links() }}
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-slate-950 p-6 text-white shadow-sm ring-1 ring-slate-900/10">
            <h3 class="text-lg font-semibold">Ringkasan Lokasi Rak</h3>
            <p class="mt-2 text-sm text-slate-300">Sistem ini membantu Anda melacak jumlah rak, status penggunaan, dan mengelola nama serta deskripsi lokasi gudang.</p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl bg-white/5 p-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Total Lokasi</p>
                    <p class="mt-3 text-3xl font-semibold">{{ $totalLocations }}</p>
                </div>
                <div class="rounded-3xl bg-white/5 p-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Rak Aktif</p>
                    <p class="mt-3 text-3xl font-semibold">{{ $activeRacks }}</p>
                </div>
                <div class="rounded-3xl bg-white/5 p-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Rak Belum Digunakan</p>
                    <p class="mt-3 text-3xl font-semibold">{{ $unusedRacks }}</p>
                </div>
                <div class="rounded-3xl bg-white/5 p-4">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Terakhir Diperbarui</p>
                    <p class="mt-3 text-3xl font-semibold">{{ optional($lastUpdated)->format('d M Y') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
