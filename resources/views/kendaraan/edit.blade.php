@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Kendaraan</h1>
            <p class="mt-2 text-slate-600">Perbarui data kendaraan sesuai kondisi terakhir.</p>
        </div>
        <a href="{{ route('kendaraan.index') }}" class="group inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">Kembali ke Daftar</a>
    </div>

    @if($errors->any())
        <div class="rounded-3xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-800 shadow-sm">
            Terdapat beberapa input yang harus diperbaiki.
        </div>
    @endif

    <form action="{{ route('kendaraan.update', $kendaraan) }}" method="POST" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('kendaraan._form')
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('kendaraan.index') }}" class="group inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">Batal</a>
            <button type="submit" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition cursor-pointer">Perbarui Kendaraan</button>
        </div>
    </form>
</div>
@endsection
