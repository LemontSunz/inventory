@extends('layouts.app')

@section('title', 'Edit Barang Masuk - LogistikPro')

@section('content')
<div class="min-h-screen bg-slate-100 px-4 py-5 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-screen-2xl">
        <div class="mb-5 flex flex-col gap-4 border-b border-slate-200 pb-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Edit Barang Masuk</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Perbarui transaksi barang masuk dan detail item.</p>
            </div>
            <a href="{{ route('barang-masuk.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali ke Daftar</a>
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

        @php
            $oldItems = old('items');
            if (is_null($oldItems)) {
                $oldItems = $incomingGoods->details->map(function ($detail) {
                    return [
                        'item_id' => $detail->item_id,
                        'quantity_received' => $detail->quantity_received,
                        'rack_location_id' => $detail->rack_location_id,
                    ];
                })->toArray();
            }
        @endphp

        <form action="{{ route('barang-masuk.update', $incomingGoods->id) }}" method="POST" class="space-y-8 rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-8 xl:grid-cols-3">
                <div class="xl:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">No. Terima</label>
                            <input type="text" name="receiving_code" value="{{ old('receiving_code', $incomingGoods->receiving_code) }}" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Terima</label>
                            <input type="date" name="receiving_date" value="{{ old('receiving_date', $incomingGoods->receiving_date->toDateString()) }}" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Supplier</label>
                            <select name="supplier_id" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $incomingGoods->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">No. Surat Jalan</label>
                            <input type="text" name="delivery_order_number" value="{{ old('delivery_order_number', $incomingGoods->delivery_order_number) }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div class="rounded-4xl border border-slate-200 bg-slate-50 p-6">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Keterangan</label>
                        <textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-4 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">{{ old('description', $incomingGoods->description) }}</textarea>
                    </div>

                    <div class="rounded-4xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Detail Barang Masuk</h3>
                                <p class="text-sm text-slate-500">Perbarui daftar barang yang diterima.</p>
                            </div>
                            <button type="button" id="addItemRow" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Tambah Item</button>
                        </div>

                        <div class="mt-6 overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b border-slate-200 bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900">Barang</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900">Qty</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-900">Lokasi Rak</th>
                                        <th class="px-4 py-3 text-center font-semibold text-slate-900">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemRows" class="divide-y divide-slate-200">
                                    @foreach($oldItems as $index => $item)
                                        <tr class="item-row">
                                            <td class="px-4 py-3">
                                                <select name="items[{{ $index }}][item_id]" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
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
                                                <button type="button" class="removeItemRow inline-flex items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">Hapus</button>
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
                            <li>• Mengubah detail item akan merevisi stok secara otomatis.</li>
                            <li>• Hapus item untuk menghilangkan penerimaan tersebut dari transaksi.</li>
                            <li>• Pastikan jumlah dan rak telah dipilih dengan benar.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('barang-masuk.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 transition hover:bg-slate-50">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-slate-800">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addRowButton = document.getElementById('addItemRow');
        const itemRows = document.getElementById('itemRows');

        function createRow(index) {
            const row = document.createElement('tr');
            row.className = 'item-row';
            row.innerHTML = `
                <td class="px-4 py-3">
                    <select name="items[${index}][item_id]" required class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-sky-500 focus:outline-none focus:ring-4 focus:ring-sky-100">
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
                    <button type="button" class="removeItemRow inline-flex items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">Hapus</button>
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
                }
            }
        });

        addRowButton.addEventListener('click', function () {
            const index = itemRows.querySelectorAll('.item-row').length;
            itemRows.appendChild(createRow(index));
        });
    });
</script>
@endsection
