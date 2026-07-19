@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Detail Kendaraan</h1>
            <p class="mt-2 text-slate-600">Lihat informasi lengkap kendaraan armada.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('kendaraan.edit', $kendaraan) }}" class="group inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition cursor-pointer">Edit</a>
            <a href="{{ route('kendaraan.index') }}" class="group inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition cursor-pointer">Kembali</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Utama</h2>
            <dl class="mt-6 grid gap-4 text-sm text-slate-700 sm:grid-cols-2">
                <div>
                    <dt class="font-semibold text-slate-600">Kode Kendaraan</dt>
                    <dd class="mt-1">{{ $kendaraan->kode_kendaraan }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Nama Kendaraan</dt>
                    <dd class="mt-1">{{ $kendaraan->nama_kendaraan }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Jenis</dt>
                    <dd class="mt-1">{{ $kendaraan->jenis_kendaraan }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Plat Nomor</dt>
                    <dd class="mt-1">{{ $kendaraan->plat_nomor }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Kapasitas Muatan</dt>
                    <dd class="mt-1">{{ number_format($kendaraan->kapasitas_muatan, 0) }} kg</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Kilometer</dt>
                    <dd class="mt-1">{{ number_format($kendaraan->kilometer, 0) }} km</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Tahun Pembuatan</dt>
                    <dd class="mt-1">{{ $kendaraan->tahun_pembuatan }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-600">Warna</dt>
                    <dd class="mt-1">{{ $kendaraan->warna }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-slate-600">Status</dt>
                    @php $style = App\Models\Kendaraan::statusStyles()[$kendaraan->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700']; @endphp
                    <dd class="mt-1">
                        <span class="group inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 text-sm font-semibold {{ $style['bg'] }} {{ $style['text'] }}">
                            <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
                            {{ $kendaraan->status }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Catatan Kendaraan</h2>
            <div class="mt-6 rounded-3xl bg-white p-5 text-sm text-slate-700 shadow-sm">
                <p class="whitespace-pre-line">{{ $kendaraan->catatan ?? 'Belum ada catatan tambahan.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
