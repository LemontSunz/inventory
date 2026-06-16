@php
    $jenisKendaraan = App\Models\Kendaraan::jenisKendaraan();
    $statuses = App\Models\Kendaraan::statuses();
@endphp
<div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
    <div class="space-y-5 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
        <div>
            <label class="block text-sm font-semibold text-slate-700">Nama Kendaraan</label>
            <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan ?? '') }}" required
                class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="block text-sm font-semibold text-slate-700">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" required
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <option value="">Pilih jenis</option>
                    @foreach($jenisKendaraan as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan ?? '') === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700">Plat Nomor</label>
                <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $kendaraan->plat_nomor ?? '') }}" required
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <div>
                <label class="block text-sm font-semibold text-slate-700">Kapasitas Muatan (kg)</label>
                <input type="number" name="kapasitas_muatan" min="0" value="{{ old('kapasitas_muatan', $kendaraan->kapasitas_muatan ?? '') }}" required
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Kilometer</label>
                <input type="number" name="kilometer" min="0" value="{{ old('kilometer', $kendaraan->kilometer ?? 0) }}" required
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700">Tahun Pembuatan</label>
                <input type="number" name="tahun_pembuatan" min="1900" max="{{ date('Y') }}" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan ?? '') }}" required
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700">Warna</label>
            <input type="text" name="warna" value="{{ old('warna', $kendaraan->warna ?? '') }}" required
                class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100" />
        </div>
    </div>

    <div class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <label class="block text-sm font-semibold text-slate-700">Status Kendaraan</label>
            <select name="status" required
                class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">
                <option value="">Pilih status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ old('status', $kendaraan->status ?? '') === $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700">Catatan Tambahan</label>
            <textarea name="catatan" rows="5"
                class="mt-2 w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-4 focus:ring-slate-100">{{ old('catatan', $kendaraan->catatan ?? '') }}</textarea>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
            <p class="font-semibold text-slate-800">Tip</p>
            <p>Gunakan catatan untuk mencatat kondisi kendaraan, perawatan terakhir, atau rute khusus.</p>
        </div>
    </div>
</div>
