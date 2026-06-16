@extends('layouts.app')

@section('title', 'Edit Barang - LogistikPro')

@section('content')
<div class="mx-auto max-w-2xl">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <a href="{{ route('barang.index') }}" class="hover:text-gray-900">Data Barang</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Edit Barang</span>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Edit Data Barang</h2>
        <p class="mt-2 text-gray-600">Perbarui informasi barang: <span class="font-semibold">{{ $barang->nama_barang }}</span></p>
    </div>

    <!-- Form Card -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="font-semibold text-gray-900">Informasi Barang</h3>
        </div>

        <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Kode Barang -->
            <div>
                <label for="kode_barang" class="block text-sm font-medium text-gray-700 mb-2">Kode Barang <span class="text-red-600">*</span></label>
                <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" placeholder="Contoh: BR-001" class="w-full rounded-lg border @error('kode_barang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
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
                <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" placeholder="Masukkan nama barang" class="w-full rounded-lg border @error('nama_barang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
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
                        <option value="Refrigeration" {{ old('kategori', $barang->kategori) == 'Refrigeration' ? 'selected' : '' }}>Refrigeration</option>
                        <option value="Kitchen Equipment" {{ old('kategori', $barang->kategori) == 'Kitchen Equipment' ? 'selected' : '' }}>Kitchen Equipment</option>
                        <option value="Packing" {{ old('kategori', $barang->kategori) == 'Packing' ? 'selected' : '' }}>Packing</option>
                        <option value="Bakery Equipment" {{ old('kategori', $barang->kategori) == 'Bakery Equipment' ? 'selected' : '' }}>Bakery Equipment</option>
                        @if(!in_array(old('kategori', $barang->kategori), ['Refrigeration','Kitchen Equipment','Packing','Bakery Equipment'], true) && (old('kategori', $barang->kategori)))
                            <option value="{{ old('kategori', $barang->kategori) }}" selected>{{ old('kategori', $barang->kategori) }}</option>
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
                    <select id="satuan" name="satuan" class="w-full rounded-lg border @error('satuan') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        <option value="">Pilih satuan</option>
                        <option value="Unit" {{ old('satuan', $barang->satuan) == 'Unit' ? 'selected' : '' }}>Unit</option>
                        <option value="Box" {{ old('satuan', $barang->satuan) == 'Box' ? 'selected' : '' }}>Box</option>
                        <option value="Pcs" {{ old('satuan', $barang->satuan) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="Kg" {{ old('satuan', $barang->satuan) == 'Kg' ? 'selected' : '' }}>Kg</option>
                        <option value="Meter" {{ old('satuan', $barang->satuan) == 'Meter' ? 'selected' : '' }}>Meter</option>
                        <option value="Liter" {{ old('satuan', $barang->satuan) == 'Liter' ? 'selected' : '' }}>Liter</option>
                    </select>
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



            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-gray-400">(Opsional)</span></label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi barang (spesifikasi, fitur, dll)" class="w-full rounded-lg border @error('deskripsi') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition resize-none">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
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
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Perbarui Barang
                </button>
                <a href="{{ route('barang.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 rounded-lg bg-blue-50 border border-blue-200 p-4">
        <div class="flex gap-3">
            <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold">Informasi Tambahan</p>
                <p class="mt-1">Dibuat: <span class="font-medium">{{ $barang->created_at->format('d M Y H:i') }}</span></p>
                <p>Diperbarui: <span class="font-medium">{{ $barang->updated_at->format('d M Y H:i') }}</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
