@extends('layouts.app')

@section('title', 'Tambah Cabang - LogistikPro')

@section('content')
<div class="mx-auto max-w-2xl">
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600">
        <a href="{{ route('cabang.index') }}" class="hover:text-gray-900">Data Cabang</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>Tambah Cabang</span>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Tambah Cabang Baru</h2>
        <p class="mt-2 text-gray-600">Lengkapi form di bawah untuk menambahkan data cabang baru</p>
    </div>

    <!-- Form Card -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="font-semibold text-gray-900">Informasi Cabang</h3>
        </div>

        <form action="{{ route('cabang.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Kode Cabang -->
            <div>
                <label for="kode_cabang" class="block text-sm font-medium text-gray-700 mb-2">Kode Cabang <span class="text-red-600">*</span></label>
                <input type="text" id="kode_cabang" name="kode_cabang" value="{{ old('kode_cabang') }}" placeholder="Contoh: CB-001"
                    class="w-full rounded-lg border @error('kode_cabang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                @error('kode_cabang')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Cabang -->
            <div>
                <label for="nama_cabang" class="block text-sm font-medium text-gray-700 mb-2">Nama Cabang <span class="text-red-600">*</span></label>
                <input type="text" id="nama_cabang" name="nama_cabang" value="{{ old('nama_cabang') }}" placeholder="Masukkan nama cabang"
                    class="w-full rounded-lg border @error('nama_cabang') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                @error('nama_cabang')
                    <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Row: Kota & Alamat -->
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">Kota <span class="text-red-600">*</span></label>
                    <input type="text" id="kota" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Jakarta"
                        class="w-full rounded-lg border @error('kota') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                    @error('kota')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-600">*</span></label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat cabang"
                        class="w-full rounded-lg border @error('alamat') border-red-500 @else border-gray-300 @enderror bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition" />
                    @error('alamat')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Cabang
                </button>
                <a href="{{ route('cabang.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
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

