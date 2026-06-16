@extends('layouts.app')

@section('title', 'Tambah Lokasi Rak - LogistikPro')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-950">Tambah Lokasi Rak</h2>
            <p class="mt-2 text-sm text-slate-600">Tambahkan lokasi rak baru untuk memperkuat struktur penyimpanan gudang.</p>
        </div>
        <a href="{{ route('lokasi-rak.index') }}" class="inline-flex items-center gap-2 rounded-3xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form action="{{ route('lokasi-rak.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('rak-lokasi._form')
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Lokasi</button>
                <a href="{{ route('lokasi-rak.index') }}" class="inline-flex items-center justify-center rounded-3xl border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
