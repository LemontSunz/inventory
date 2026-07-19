@extends('layouts.app')

@section('title', 'Tambah Barang Masuk - Inventory')

@section('content')
<div class="min-h-screen bg-slate-100 px-4 py-5 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-screen-2xl">
        <div class="mb-5 flex flex-col gap-4 border-b border-slate-200 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">BARANG MASUK</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Buat transaksi barang masuk untuk memperbarui stok gudang.</p>
            </div>

            <a href="{{ route('barang-masuk.index') }}" class="group inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Kembali ke Daftar</a>
        </div>

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                <p class="font-semibold">Periksa kembali data berikut:</p>
                <ul class="mt-3 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('barang-masuk.store') }}" class="space-y-8 rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
            @csrf

            <div class="grid gap-8 xl:grid-cols-3">
                <div class="xl:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Terima</label>
                            <input type="date" name="receiving_date" value="{{ old('receiving_date', now()->toDateString()) }}" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Supplier</label>
                            <input 
                                type="text"
                                name="supplier"
                                id="supplier"
                                placeholder="Masukkan nama supplier"
                                value="{{ old('supplier', '') }}"
                                required
                                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">No. Surat Jalan</label>
                            <input type="text" name="delivery_order_number" value="{{ old('delivery_order_number') }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div class="rounded-4xl border border-slate-200 bg-slate-50 p-6">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Keterangan</label>
                        <textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">{{ old('description') }}</textarea>
                    </div>

                    <div class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Detail Barang Masuk</h3>
                                <p class="text-sm text-slate-500">Tambah satu atau lebih barang yang diterima.</p>
                            </div>
                            <button type="button" id="addItemRow" class="group inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Tambah Item</button>
                        </div>

                        <div class="mt-6 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b border-slate-200 bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900" style="width: 35%;">Barang</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900" style="width: 20%;">Qty</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900" style="width: 25%;">Lokasi Rak</th>
                                        <th class="px-4 py-3 text-center font-semibold text-slate-900" style="width: 20%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemRows" class="divide-y divide-slate-200">
                                    @php
                                        $oldItems = old('items', []);
                                        if (empty($oldItems)) {
                                            $oldItems = [[
                                                'item_id' => '',
                                                'quantity_received' => 1,
                                                'rack_location_id' => '',
                                            ]];
                                        }
                                    @endphp

                                    @foreach($oldItems as $index => $item)
                                        <tr class="item-row">
                                            <td class="px-4 py-3">
                                                <select name="items[{{ $index }}][item_id]" required class="select2-barang w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                                    <option value="">-- Pilih Barang --</option>
                                                    @foreach($barangs as $barang)
                                                        <option value="{{ $barang->id }}" {{ isset($item['item_id']) && $item['item_id'] == $barang->id ? 'selected' : '' }}>{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="items[{{ $index }}][quantity_received]" min="1" value="{{ $item['quantity_received'] ?? 1 }}" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="items[{{ $index }}][rack_location_id]" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                                    <option value="">-- Pilih Rak --</option>
                                                    @foreach($rackLocations as $location)
                                                        <option value="{{ $location->id }}" {{ isset($item['rack_location_id']) && $item['rack_location_id'] == $location->id ? 'selected' : '' }}>{{ $location->code }}{{ $location->label ? ' - '.$location->label : '' }}</option>
                                                    @endforeach
                                                </select>
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
                </div>

                <div class="space-y-6">
                    <div class="rounded-4xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm text-slate-500">Ringkasan Transaksi</p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-600">
                            <li>• Gunakan formulir ini untuk menambahkan banyak barang sekaligus dalam satu transaksi.</li>
                            <li>• Setiap barang akan menambah stok pada saat disimpan.</li>
                            <li>• Pilih lokasi rak agar stok terhubung dengan posisi fisik di gudang.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('barang-masuk.index') }}" class="group inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer">Batal</a>
                <button type="submit" class="group inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-slate-800 cursor-pointer">Simpan Barang Masuk</button>
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
                    <select name="items[${index}][item_id]" required class="select2-barang w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${index}][quantity_received]" min="1" value="1" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                </td>
                <td class="px-4 py-3">
                    <select name="items[${index}][rack_location_id]" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                        <option value="">-- Pilih Rak --</option>
                        @foreach($rackLocations as $location)
                            <option value="{{ $location->id }}">{{ $location->code }}{{ $location->label ? ' - '.$location->label : '' }}</option>
                        @endforeach
                    </select>
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
                    const name = field.name.replace(/items\[\d+\]/, `items[${index}]`);
                    field.name = name;
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
