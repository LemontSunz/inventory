@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-500">Project Inventory</p>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Sistem SaaS untuk manajemen stok & proyek.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600">Dashboard ini menampilkan ringkasan persediaan, supplier, status project, dan laporan bisnis secara real time.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="rounded-full bg-sky-50 px-4 py-2 text-sm text-sky-700">24/7 monitoring</span>
                    <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm text-emerald-700">Stok otomatis</span>
                    <span class="rounded-full bg-violet-50 px-4 py-2 text-sm text-violet-700">Laporan SaaS</span>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Total Produk</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-950">1.248</p>
                    <p class="mt-2 text-xs text-slate-500">32 kategori produk</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Stok Rendah</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-950">18</p>
                    <p class="mt-2 text-xs text-slate-500">Butuh restock cepat</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Supplier Aktif</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-950">42</p>
                    <p class="mt-2 text-xs text-slate-500">Pemasok berperingkat tinggi</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Order Tertunda</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-950">7</p>
                    <p class="mt-2 text-xs text-slate-500">Purchase order dalam proses</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-950">Ringkasan Inventori</h2>
                    <p class="mt-1 text-sm text-slate-500">Visualisasi tingkat stok dan permintaan.</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <div class="rounded-full bg-slate-100 px-3 py-2">Tingkat pemesanan</div>
                    <div class="rounded-full bg-slate-100 px-3 py-2">Proyeksi 30 hari</div>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Persediaan cepat bergerak</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-950">86%</p>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-2 w-[86%] rounded-full bg-sky-500"></div>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Level stok sehat</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-950">68%</p>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-2 w-[68%] rounded-full bg-emerald-500"></div>
                    </div>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Pengiriman tepat waktu</p>
                    <p class="mt-3 text-2xl font-semibold text-slate-950">93%</p>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200">
                        <div class="h-2 w-[93%] rounded-full bg-violet-500"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-slate-100 p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm text-slate-500">Tren permintaan</p>
                        <p class="mt-1 text-2xl font-semibold text-slate-950">+14.2%</p>
                    </div>
                    <span class="rounded-full bg-white px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Stabil</span>
                </div>
                <div class="mt-6 grid grid-cols-4 gap-3 text-center text-xs text-slate-500 md:grid-cols-8">
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Sen</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Sel</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Rab</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Kam</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Jum</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Sab</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Min</div>
                    <div class="rounded-3xl bg-white p-3 shadow-sm">Avg</div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Aksi Cepat</h2>
                        <p class="mt-1 text-sm text-slate-500">Tools untuk menambahkan dan memantau item penting.</p>
                    </div>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <button class="rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-left text-sm font-semibold text-slate-900 transition hover:border-slate-300 hover:bg-slate-100 cursor-pointer">Tambah Produk Baru</button>
                    <button class="rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-left text-sm font-semibold text-slate-900 transition hover:border-slate-300 hover:bg-slate-100 cursor-pointer">Buat Purchase Order</button>
                    <button class="rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-left text-sm font-semibold text-slate-900 transition hover:border-slate-300 hover:bg-slate-100 cursor-pointer">Atur Supplier</button>
                    <button class="rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-left text-sm font-semibold text-slate-900 transition hover:border-slate-300 hover:bg-slate-100 cursor-pointer">Lihat Laporan</button>
                </div>
            </div>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-950">Aktivitas Terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">Perubahan terakhir pada stok dan pembelian.</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">3 acara</span>
                </div>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Pembelian perangkat baru</p>
                        <p class="mt-1 text-sm text-slate-500">PO #1178 disetujui untuk supplier kantor.</p>
                        <p class="mt-2 text-xs text-slate-400">2 menit lalu</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Stok printer menipis</p>
                        <p class="mt-1 text-sm text-slate-500">Hanya 4 unit tersisa di gudang A.</p>
                        <p class="mt-2 text-xs text-slate-400">1 jam lalu</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-4">
                        <p class="text-sm font-semibold text-slate-900">Project instalasi selesai</p>
                        <p class="mt-1 text-sm text-slate-500">Inventory deployment 2025 telah rampung.</p>
                        <p class="mt-2 text-xs text-slate-400">3 jam lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Detail Produk & Stok</h2>
                <p class="mt-1 text-sm text-slate-500">Filter dengan kata kunci untuk menampilkan item yang relevan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 cursor-pointer">Semua</button>
                <button class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 cursor-pointer">Stok Rendah</button>
                <button class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 cursor-pointer">Supplier Baru</button>
                <button class="rounded-2xl border border-slate-200 bg-slate-100 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 cursor-pointer">Project</button>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.15em] text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody id="inventoryTable" class="divide-y divide-slate-200 bg-white">
                    <tr data-tags="printer,hardware,office" class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Printer LaserJet</td>
                        <td class="px-6 py-4">Hardware</td>
                        <td class="px-6 py-4">4</td>
                        <td class="px-6 py-4">BioTech Supply</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Perlu Restock</span></td>
                        <td class="px-6 py-4">12 Mei 2026</td>
                    </tr>
                    <tr data-tags="cable,accessories,network" class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Kabel Ethernet Cat6</td>
                        <td class="px-6 py-4">Aksesori</td>
                        <td class="px-6 py-4">120</td>
                        <td class="px-6 py-4">NetLink Corp</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span></td>
                        <td class="px-6 py-4">14 Mei 2026</td>
                    </tr>
                    <tr data-tags="battery,power,backup" class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Baterai Cadangan UPS</td>
                        <td class="px-6 py-4">Daya</td>
                        <td class="px-6 py-4">6</td>
                        <td class="px-6 py-4">PowerHub</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Perlu Restock</span></td>
                        <td class="px-6 py-4">11 Mei 2026</td>
                    </tr>
                    <tr data-tags="monitor,display,office" class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Monitor 27" 4K</td>
                        <td class="px-6 py-4">Display</td>
                        <td class="px-6 py-4">22</td>
                        <td class="px-6 py-4">VisionPro</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span></td>
                        <td class="px-6 py-4">10 Mei 2026</td>
                    </tr>
                    <tr data-tags="server,hardware,network" class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-semibold text-slate-900">Server Rack 2U</td>
                        <td class="px-6 py-4">Infrastructure</td>
                        <td class="px-6 py-4">8</td>
                        <td class="px-6 py-4">DataSystems</td>
                        <td class="px-6 py-4"><span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span></td>
                        <td class="px-6 py-4">13 Mei 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
