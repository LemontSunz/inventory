@extends('layouts.app')

@section('title', 'Edit Barang Keluar - LogistikPro')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Barang Keluar</h2>
            <p class="mt-1 text-gray-600">Perbarui data pengeluaran barang</p>
        </div>
        <a href="{{ route('barang-keluar.index') }}" class="group inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition cursor-pointer">Kembali</a>
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

        <form action="{{ route('barang-keluar.update', $barangKeluar->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cabang Tujuan</label>
                    <select name="cabang_id" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ (old('cabang_id', $barangKeluar->cabang_id) == $c->id) ? 'selected' : '' }}>{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Driver</label>
                    <select name="driver_id" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">-- Pilih Driver (opsional) --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ (old('driver_id', $barangKeluar->driver_id) == $driver->id) ? 'selected' : '' }}>{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kendaraan</label>
                    <select name="kendaraan_id" class="mt-1 w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="">-- Pilih Kendaraan (opsional) --</option>
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ (old('kendaraan_id', $barangKeluar->kendaraan_id) == $kendaraan->id) ? 'selected' : '' }}>{{ $kendaraan->kode_kendaraan }} - {{ $kendaraan->nama_kendaraan }}</option>
                        @endforeach
                    </select>
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

            <div class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Detail Barang Keluar</h3>
                        <p class="text-sm text-slate-500">Perbarui item yang termasuk dalam transaksi ini.</p>
                    </div>
                    <button type="button" id="addItemRow" class="group inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Tambah Item</button>
                </div>

                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900" style="width: 60%;">Barang</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-900" style="width: 20%;">Qty</th>
                                <th class="px-4 py-3 text-center font-semibold text-slate-900" style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemRows" class="divide-y divide-slate-200">
                            @php
                                $oldItems = old('items', []);
                                if (empty($oldItems)) {
                                    $oldItems = $barangKeluar->details->map(function ($detail) {
                                        return [
                                            'barang_id' => $detail->barang_id,
                                            'jumlah_keluar' => $detail->jumlah_keluar,
                                        ];
                                    })->toArray();
                                }

                                if (empty($oldItems)) {
                                    $oldItems = [[
                                        'barang_id' => '',
                                        'jumlah_keluar' => 1,
                                    ]];
                                }
                            @endphp

                            @foreach($oldItems as $index => $item)
                                <tr class="item-row">
                                    <td class="px-4 py-3">
                                        <select name="items[{{ $index }}][barang_id]" required class="select2-barang w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->id }}" {{ isset($item['barang_id']) && $item['barang_id'] == $barang->id ? 'selected' : '' }}>{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="items[{{ $index }}][jumlah_keluar]" min="1" value="{{ $item['jumlah_keluar'] ?? 1 }}" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" class="group removeItemRow inline-flex items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100 cursor-pointer">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="group inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition cursor-pointer">Simpan</button>
                <a href="{{ route('barang-keluar.index') }}" class="group inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition cursor-pointer">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Select2 compact dropdown styling */
    .select2-dropdown-compact.select2-dropdown {
        max-width: 500px;
    }
    
    .select2-dropdown-compact .select2-search {
        padding: 4px;
    }
    
    .select2-dropdown-compact .select2-results__options {
        max-height: 300px;
        padding: 2px 0;
    }
    
    .select2-dropdown-compact .select2-results__option {
        padding: 6px 12px;
        font-size: 0.875rem;
    }
    
    /* Ensure select2 container width matches input fields */
    .select2-container--default .select2-selection--single {
        border-radius: 1rem;
        border-color: #cbd5e1;
        height: auto;
        padding: 8px 12px;
    }
    
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addRowButton = document.getElementById('addItemRow');
        const itemRows = document.getElementById('itemRows');

        function initSelect2() {
            $('.select2-barang').select2({
                placeholder: '-- Pilih Barang --',
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: false,
                dropdownCssClass: 'select2-dropdown-compact',
            });
        }

        function createRow(index) {
            const row = document.createElement('tr');
            row.className = 'item-row';
            row.innerHTML = `
                <td class="px-4 py-3">
                    <select name="items[${index}][barang_id]" required class="select2-barang w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${index}][jumlah_keluar]" min="1" value="1" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" class="group removeItemRow inline-flex items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100 cursor-pointer">Hapus</button>
                </td>
            `;
            return row;
        }

        function updateRowIndexes() {
            itemRows.querySelectorAll('.item-row').forEach((row, index) => {
                row.querySelectorAll('select, input').forEach((field) => {
                    field.name = field.name.replace(/items\[\d+\]/, `items[${index}]`);
                });
            });
        }

        itemRows.addEventListener('click', function (event) {
            if (event.target.matches('.removeItemRow')) {
                const rows = itemRows.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    event.target.closest('tr').remove();
                    updateRowIndexes();
                    initSelect2();
                }
            }
        });

        addRowButton.addEventListener('click', function () {
            const index = itemRows.querySelectorAll('.item-row').length;
            itemRows.appendChild(createRow(index));
            initSelect2();
        });

        // Initialize Select2 on page load
        initSelect2();
    });
</script>
@endsection

