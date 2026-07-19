@extends('layouts.app')

@section('title', 'Armada - Daftar Kendaraan')

@section('content')
<div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Armada</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Daftar Kendaraan</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola data kendaraan yang digunakan dalam proses distribusi barang untuk mendukung operasional logistik.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('kendaraan.create') }}" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Tambah Kendaraan</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php
        $totalKendaraan = App\Models\Kendaraan::count();
        $totalSiap = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_SIAP)->count();
        $totalBertugas = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_BERTUGAS)->count();
        $totalPerawatan = App\Models\Kendaraan::where('status', App\Models\Kendaraan::STATUS_PERAWATAN)->count();
        $kendaraanAktif = $totalSiap;
        $kendaraanPerawatan = $totalPerawatan;
        $dataLengkap = App\Models\Kendaraan::whereNotNull('nama_kendaraan')
            ->whereNotNull('plat_nomor')
            ->whereNotNull('jenis_kendaraan')
            ->whereNotNull('kapasitas_muatan')
            ->whereNotNull('status')
            ->count();
    @endphp

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Kendaraan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalKendaraan }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah seluruh kendaraan yang terdaftar pada sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Siap Pakai</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $totalSiap }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan siap digunakan untuk proses distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sedang Bertugas</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalBertugas }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang digunakan untuk distribusi barang.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
            <p class="mt-4 text-4xl font-semibold text-rose-700">{{ $totalPerawatan }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang menjalani perawatan atau perbaikan.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('kendaraan.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Kendaraan</label>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Kode, nama, plat, jenis"
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Status Armada</label>
                <select name="status"
                    class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Semua Status</option>
                    @foreach(App\Models\Kendaraan::statuses() as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Terapkan</button>
                <a href="{{ route('kendaraan.index') }}" class="group inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Reset</a>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%] rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Tabel Kendaraan</h2>
                    <p class="mt-1 text-sm text-slate-500">Daftar lengkap kendaraan beserta informasi armada.</p>
                </div>
                <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $kendaraan->total() }}</div>
            </div>

            <div class="mt-6 table-standard-wrapper">
                <table class="table-standard">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-col-code">
                                @php
                                    $isSorted = $sort === 'kode_kendaraan';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'kode_kendaraan', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('kendaraan.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Kode
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
                                    $isSorted = $sort === 'nama_kendaraan';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'nama_kendaraan', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('kendaraan.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Nama
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
                                    $isSorted = $sort === 'jenis_kendaraan';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'jenis_kendaraan', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('kendaraan.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Jenis
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
                                    $isSorted = $sort === 'plat_nomor';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'plat_nomor', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('kendaraan.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Plat
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
                            <th class="px-4 py-3 font-semibold">Muatan</th>
                            <th class="table-col-status">
                                @php
                                    $isSorted = $sort === 'status';
                                    $nextDirection = $isSorted && $direction === 'asc' ? 'desc' : 'asc';
                                    $params = array_merge(request()->query(), ['sort' => 'status', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('kendaraan.index', $params) }}" class="group inline-flex items-center gap-2 hover:text-slate-900 transition">
                                    Status
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
                            <th class="table-col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($kendaraan as $item)
                            @php $style = App\Models\Kendaraan::statusStyles()[$item->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400']; @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="table-col-code font-semibold text-slate-900">{{ $item->kode_kendaraan }}</td>
                                <td>{{ $item->nama_kendaraan }}</td>
                                <td>{{ $item->jenis_kendaraan }}</td>
                                <td class="whitespace-nowrap">{{ $item->plat_nomor }}</td>
                                <td class="table-col-qty">{{ number_format($item->kapasitas_muatan, 0) }} kg</td>
                                <td class="table-col-status">
                                    <span class="badge-consistent {{ $style['bg'] }} {{ $style['text'] }}">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }} mr-2"></span>
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="table-col-actions text-center">
                                    <div class="inline-flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('kendaraan.show', $item) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">Detail</a>
                                        @if(auth()->user()->role === 'admin_gudang')
                                            <a href="{{ route('kendaraan.edit', $item) }}" class="rounded-2xl bg-blue-50 px-3 py-2 text-[11px] font-semibold text-blue-700 hover:bg-blue-100 cursor-pointer">Edit</a>
                                            <form action="{{ route('kendaraan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kendaraan ini?');">
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
                                <td colspan="7" class="px-4 py-16 text-center text-slate-500">
                                    Belum ada data kendaraan. Tambahkan kendaraan armada baru sekarang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between text-sm text-slate-600">
                <div>
                    Menampilkan <strong>{{ $kendaraan->firstItem() ?? 0 }}</strong> sampai <strong>{{ $kendaraan->lastItem() ?? 0 }}</strong> dari <strong>{{ $kendaraan->total() }}</strong> kendaraan
                </div>
                <div>{{ $kendaraan->links() }}</div>
            </div>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Status Kendaraan</h3>
                <p class="mt-2 text-sm text-slate-500">Ringkasan kondisi data kendaraan pada sistem logistik.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Kendaraan Aktif</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $kendaraanAktif }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-700">{{ $kendaraanPerawatan }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Data Lengkap</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $dataLengkap }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
