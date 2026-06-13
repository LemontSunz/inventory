@extends('layouts.app')

@section('title', 'Edit Barang Keluar - LogistikPro')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Barang Keluar</h2>
            <p class="mt-1 text-gray-600">Perbarui data pengeluaran barang</p>
        </div>
        <a href="{{ route('barang-keluar.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Kembali</a>
    </div>

    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-6">
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4">
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang-keluar.update', $barangKeluar->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Barang</label>
                    <select name="barang_id" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}" {{ (old('barang_id', $barangKeluar->barang_id) == $b->id) ? 'selected' : '' }}>{{ $b->kode_barang }} - {{ $b->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Cabang Tujuan</label>
                    <select name="cabang_id" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ (old('cabang_id', $barangKeluar->cabang_id) == $c->id) ? 'selected' : '' }}>{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah Keluar</label>
                    <input type="number" name="jumlah_keluar" value="{{ old('jumlah_keluar', $barangKeluar->jumlah_keluar) }}" min="1" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', optional($barangKeluar->tanggal_keluar)->toDateString()) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required />
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" rows="3">{{ old('keterangan', $barangKeluar->keterangan) }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">Simpan</button>
                <a href="{{ route('barang-keluar.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

