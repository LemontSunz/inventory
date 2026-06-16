@extends('layouts.app')

@section('title', 'Armada - Tambah Driver')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Tambah Driver Armada</h1>
            <p class="mt-2 text-slate-600">Catat informasi driver baru dan atur status armada dengan cepat.</p>
        </div>
        <a href="{{ route('armada.drivers.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali ke Daftar</a>
    </div>

    @if($errors->any())
        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800 shadow-sm">
            Periksa kembali beberapa kolom yang belum diisi dengan benar.
        </div>
    @endif

    <form action="{{ route('armada.drivers.store') }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @include('armada.drivers._form')

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('armada.drivers.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Driver</button>
        </div>
    </form>
</div>
@endsection
