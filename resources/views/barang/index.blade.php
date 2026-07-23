@extends('layouts.app')

@section('title', 'Data Barang - PT. Karya Makmur Mesindo')

@section('content')
<div class="space-y-4 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">

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

    <x-page-header
        category="Manajemen Gudang"
        title="Kelola Data Barang"
        description="Kelola data barang yang tersimpan di gudang untuk mendukung pengelolaan stok secara akurat."
    >
        <x-slot:actionButton>
            @if(auth()->user()->role === 'admin_gudang')
                <a href="{{ route('barang.create') }}" class="group inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            @endif
        </x-slot:actionButton>
    </x-page-header>



    <x-filter.filter-panel action="{{ route('barang.index') }}" gridClass="grid gap-4 lg:grid-cols-[1.5fr_1fr_0.9fr]">
        <x-filter.search-input
            name="search"
            label="Cari Barang"
            value="{{ request('search') }}"
            placeholder="Cari kode barang, nama, atau kategori..."
        />

        <x-filter.select-input name="kategori" label="Kategori">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </x-filter.select-input>

        <div class="flex items-end gap-3">
            <x-filter.filter-button>Cari</x-filter.filter-button>
            <x-filter.reset-button :href="route('barang.index')">Reset</x-filter.reset-button>
        </div>
    </x-filter.filter-panel>

    <x-table.table-wrapper title="Tabel Barang" description="Daftar lengkap barang yang tersedia untuk pengelolaan stok." :count="$barang->total()">
        @if($barang->count() > 0)
            <div class="w-full overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <x-table.table-header label="No" align="center" class="w-[5%] min-w-[56px]" />
                            <x-table.table-header label="Kode Barang" align="center" class="w-[12%] min-w-[110px]" />
                            <x-table.table-header label="Nama Barang" align="left" class="w-[40%] min-w-[220px]" />
                            <x-table.table-header label="Kategori" align="center" class="w-[23%] min-w-[140px]" />
                            <x-table.table-header label="Satuan" align="center" class="w-[8%] min-w-[90px]" />
                            <x-table.table-header label="Aksi" align="center" class="w-[12%] min-w-[160px]" />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $item)
                            <x-table.table-row>
                                <x-table.table-cell align="center" class="font-semibold text-slate-900">{{ $barang->firstItem() + $loop->index }}</x-table.table-cell>
                                <x-table.table-cell align="center">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $item->kode_barang }}</span>
                                </x-table.table-cell>
                                <x-table.table-cell align="left">
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $item->nama_barang }}</p>
                                        @if($item->deskripsi)
                                            <p class="mt-1 text-xs leading-5 text-slate-500">{{ Str::limit($item->deskripsi, 80) }}</p>
                                        @endif
                                    </div>
                                </x-table.table-cell>
                                <x-table.table-cell align="center" class="whitespace-nowrap text-slate-600">{{ $item->kategori }}</x-table.table-cell>
                                <x-table.table-cell align="center" class="whitespace-nowrap text-slate-600">{{ $item->satuan }}</x-table.table-cell>
                                <x-table.table-cell align="center">
                                    @if(auth()->user()->role === 'admin_gudang')
                                        <x-table.action-buttons :edit-route="route('barang.edit', $item->id)" :delete-route="route('barang.destroy', $item->id)" delete-confirm="Apakah Anda yakin ingin menghapus data barang ini?" />
                                    @else
                                        <span class="text-slate-500">Hanya lihat</span>
                                    @endif
                                </x-table.table-cell>
                            </x-table.table-row>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-table.pagination :paginator="$barang" />
        @else
            <x-table.table-empty title="Tidak ada data barang" description="Mulai dengan menambahkan barang baru" :action-route="auth()->user()->role === 'admin_gudang' ? route('barang.create') : null" action-label="Tambah Barang Pertama" />
        @endif
    </x-table.table-wrapper>

</div>
@endsection
