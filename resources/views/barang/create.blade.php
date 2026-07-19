@extends('layouts.app')

@section('title', 'Tambah Barang - LogistikPro')

@section('content')
<div class="mx-auto max-w-2xl">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <a href="{{ route('barang.index') }}" class="hover:text-gray-900 cursor-pointer">Data Barang</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Tambah Barang</span>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Tambah Barang Baru</h2>
        <p class="mt-2 text-gray-600">Lengkapi form di bawah untuk menambahkan data barang baru</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="font-semibold text-gray-900">Informasi Barang</h3>
        </div>

        <form action="{{ route('barang.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Kode Barang -->
            <div>
                <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-2">Kode Barang <span class="text-red-600">*</span></label>
                <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" placeholder="Contoh: BR-001" class="w-full rounded-lg border @error('kode_barang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                @error('kode_barang')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Barang -->
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">Nama Barang <span class="text-red-600">*</span></label>
                <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Masukkan nama barang" class="w-full rounded-lg border @error('nama_barang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                @error('nama_barang')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Row: Kategori & Satuan -->
            <div class="grid gap-4 sm:grid-cols-2">
                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-600">*</span></label>
                    <select id="kategori" name="kategori" class="w-full rounded-lg border @error('kategori') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        <option value="">Pilih kategori</option>
                        <option value="Refrigeration" {{ old('kategori') == 'Refrigeration' ? 'selected' : '' }}>Refrigeration</option>
                        <option value="Kitchen Equipment" {{ old('kategori') == 'Kitchen Equipment' ? 'selected' : '' }}>Kitchen Equipment</option>
                        <option value="Packaging" {{ old('kategori') == 'Packaging' ? 'selected' : '' }}>Packaging</option>
                        <option value="Bakery Equipment" {{ old('kategori') == 'Bakery Equipment' ? 'selected' : '' }}>Bakery Equipment</option>
                        @if(!in_array(old('kategori'), ['Refrigeration','Kitchen Equipment','Packaging','Bakery Equipment'], true) && old('kategori'))
                            <option value="{{ old('kategori') }}" selected>{{ old('kategori') }}</option>
                        @endif
                    </select>
                    @error('kategori')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">Satuan <span class="text-red-600">*</span></label>
                    <input type="text" id="satuan" name="satuan" value="Unit" readonly class="w-full rounded-lg border @error('satuan') border-red-500 @else border-gray-300 @enderror bg-gray-100 px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                    @error('satuan')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- (Stok dan Lokasi Rak tidak digunakan) -->

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-gray-400">(Opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi barang (spesifikasi, fitur, dll)" class="w-full rounded-lg border @error('deskripsi') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition resize-none">{{ old('deskripsi', '') }}</textarea>
                <p class="mt-1.5 text-xs text-gray-500">Maksimal 1000 karakter</p>
                @error('deskripsi')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="group flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Barang
                </button>
                <a href="{{ route('barang.index') }}" class="group flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
