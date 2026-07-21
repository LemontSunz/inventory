@extends('layouts.app')

@section('title', 'Data Cabang - LogistikPro')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <x-page-header
        category="MANAJEMEN GUDANG"
        title="Kelola Data Cabang"
        description="Kelola data cabang sebagai tujuan distribusi barang dalam operasional logistik perusahaan."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('cabang.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Cabang
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>

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

    <div class="grid gap-4 xl:grid-cols-4">
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

    <x-table.table-wrapper title="Tabel Cabang" description="Daftar lengkap cabang yang tersedia dalam sistem." :count="$cabangs->total()">
        @if($cabangs->count() > 0)
            <div class="w-full overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <x-table.table-header label="No" align="center" class="w-[6%] min-w-[56px]" />
                            <x-table.table-header label="Kode Cabang" align="center" class="w-[14%] min-w-[120px]" :sortable="true" sort-route="cabang.index" column="kode_cabang" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Nama Cabang" align="left" class="w-[24%] min-w-[180px]" :sortable="true" sort-route="cabang.index" column="nama_cabang" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Kota" align="center" class="w-[16%] min-w-[120px]" :sortable="true" sort-route="cabang.index" column="kota" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Alamat" align="left" class="w-[28%] min-w-[220px]" :sortable="true" sort-route="cabang.index" column="alamat" :current-sort="$sort" :direction="$direction" />
                            <x-table.table-header label="Aksi" align="center" class="w-[12%] min-w-[150px]" />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cabangs as $item)
                            <x-table.table-row>
                                <x-table.table-cell align="center" class="font-semibold text-slate-900">{{ $cabangs->firstItem() + $loop->index }}</x-table.table-cell>
                                <x-table.table-cell align="center">
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $item->kode_cabang }}</span>
                                </x-table.table-cell>
                                <x-table.table-cell align="left">
                                    <p class="font-medium text-slate-900">{{ $item->nama_cabang }}</p>
                                </x-table.table-cell>
                                <x-table.table-cell align="center" class="whitespace-nowrap text-slate-600">{{ $item->kota }}</x-table.table-cell>
                                <x-table.table-cell align="left" class="max-w-[28rem] align-top text-slate-600" wrap="true">{{ $item->alamat }}</x-table.table-cell>
                                <x-table.table-cell align="center">
                                    @if(auth()->user()->role === 'admin_gudang')
                                        <x-table.action-buttons :edit-route="route('cabang.edit', $item->id)" :delete-route="route('cabang.destroy', $item->id)" delete-confirm="Apakah Anda yakin ingin menghapus data cabang ini?" />
                                    @else
                                        <span class="text-slate-500">Hanya lihat</span>
                                    @endif
                                </x-table.table-cell>
                            </x-table.table-row>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-table.pagination :paginator="$cabangs" />
        @else
            <x-table.table-empty title="Tidak ada data cabang" description="Mulai dengan menambahkan cabang baru" :action-route="auth()->user()->role === 'admin_gudang' ? route('cabang.create') : null" action-label="Tambah Cabang Pertama" />
        @endif
    </x-table.table-wrapper>
</div>
@endsection


