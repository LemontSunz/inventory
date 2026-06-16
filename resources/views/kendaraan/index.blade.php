@extends('layouts.app')

@section('title', 'Kendaraan - Daftar Kendaraan')

@section('content')
    <div class="space-y-6 max-w-screen-2xl w-full mx-auto px-6 sm:px-8 lg:px-10 xl:px-12">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Armada</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight text-slate-900">Daftar Kendaraan</h1>
            <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">Kelola armada kendaraan dengan tampilan yang lebih profesional, informasi teknis jelas, dan status operasional yang mudah dibaca.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <a href="{{ route('kendaraan.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Tambah Kendaraan</a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-5 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Total Kendaraan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalKendaraan }}</p>
            <p class="mt-2 text-sm text-slate-500">Semua armada kendaraan Anda terdata di sistem.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Siap Pakai</p>
            <p class="mt-4 text-4xl font-semibold text-emerald-700">{{ $totalSiap }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang siap untuk tugas berikutnya.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Sedang Bertugas</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalBertugas }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang dipakai dalam operasi.</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
            <p class="mt-4 text-4xl font-semibold text-amber-700">{{ $totalPerawatan }}</p>
            <p class="mt-2 text-sm text-slate-500">Kendaraan yang sedang menjalani perawatan atau inspeksi.</p>
        </div>
    </div>

    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:gap-6">
        <div class="xl:basis-[65%] space-y-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Pencarian & Filter</h2>
                        <p class="mt-1 text-sm text-slate-500">Temukan kendaraan dengan cepat berdasarkan status dan detail teknis.</p>
                    </div>
                    <div class="rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Total: {{ $kendaraan->total() }}</div>
                </div>

                <form action="{{ route('kendaraan.index') }}" method="GET" class="mt-6 grid gap-4 lg:grid-cols-[1.5fr_1fr_0.75fr]">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Cari Kendaraan</label>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Kode, nama, plat, jenis"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                        <select name="status"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                            <option value="">Semua Status</option>
                            @foreach(App\Models\Kendaraan::statuses() as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="inline-flex h-12 w-full items-center justify-center rounded-2xl bg-slate-900 px-5 text-sm font-semibold text-white transition hover:bg-slate-800">Terapkan</button>
                        <a href="{{ route('kendaraan.index') }}" class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-700">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-5 py-4 font-semibold">Kode</th>
                                <th class="px-5 py-4 font-semibold">Nama</th>
                                <th class="px-5 py-4 font-semibold">Jenis</th>
                                <th class="px-5 py-4 font-semibold">Plat</th>
                                <th class="px-5 py-4 font-semibold">Muatan</th>
                                <th class="px-5 py-4 font-semibold">Status</th>
                                <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($kendaraan as $item)
                                @php $style = App\Models\Kendaraan::statusStyles()[$item->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400']; @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4 font-semibold text-slate-900">{{ $item->kode_kendaraan }}</td>
                                    <td class="px-5 py-4">{{ $item->nama_kendaraan }}</td>
                                    <td class="px-5 py-4">{{ $item->jenis_kendaraan }}</td>
                                    <td class="px-5 py-4">{{ $item->plat_nomor }}</td>
                                    <td class="px-5 py-4">{{ number_format($item->kapasitas_muatan, 0) }} kg</td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $style['bg'] }} {{ $style['text'] }}">
                                            <span class="h-2.5 w-2.5 rounded-full {{ $style['dot'] }}"></span>
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <div class="inline-flex flex-wrap justify-center gap-2">
                                            <a href="{{ route('kendaraan.show', $item) }}" class="rounded-2xl border border-slate-300 bg-white px-3 py-2 text-[11px] font-semibold text-slate-700 hover:bg-slate-50">Lihat</a>
                                            <a href="{{ route('kendaraan.edit', $item) }}" class="rounded-2xl bg-sky-50 px-3 py-2 text-[11px] font-semibold text-sky-700 hover:bg-sky-100">Edit</a>
                                            <form action="{{ route('kendaraan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kendaraan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-2xl bg-rose-50 px-3 py-2 text-[11px] font-semibold text-rose-700 hover:bg-rose-100">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-16 text-center text-slate-500">
                                        Belum ada data kendaraan. Tambahkan kendaraan armada baru sekarang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-5 py-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between text-sm text-slate-600">
                        <div>
                            Menampilkan <strong>{{ $kendaraan->firstItem() ?? 0 }}</strong> sampai <strong>{{ $kendaraan->lastItem() ?? 0 }}</strong> dari <strong>{{ $kendaraan->total() }}</strong> kendaraan
                        </div>
                        <div>{{ $kendaraan->links() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-5 xl:basis-[35%]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Insight Armada</h3>
                <p class="mt-2 text-sm text-slate-500">Lihat kondisi armada dan ambil tindakan dengan cepat.</p>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Total Kendaraan</p>
                        <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $totalKendaraan }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Siap Beroperasi</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-700">{{ $totalSiap }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Dalam Perawatan</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-700">{{ $totalPerawatan }}</p>
                    </div>
                </div>
            </div>

        </aside>
    </div>
</div>
@endsection
