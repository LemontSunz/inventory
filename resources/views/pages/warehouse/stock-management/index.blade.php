@extends('layouts.app')

@section('title', 'Mengelola Stok Barang - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Mengelola Stok Barang</h2>
            <p class="mt-2 text-gray-600">Kelola reorder point, maksimum stok, dan otomasi pembelian</p>
        </div>
        <div class="flex gap-2">
            <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export
            </button>
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Atur Reorder
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <input type="search" placeholder="Cari barang atau kategori..." class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-700 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100" />
            </div>
            <div class="flex gap-2">
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Kategori</option>
                    <option>Elektronik</option>
                    <option>Aksesoris</option>
                    <option>Peralatan</option>
                </select>
                <select class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option>Semua Prioritas</option>
                    <option>Tinggi</option>
                    <option>Sedang</option>
                    <option>Rendah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Kanban Board Layout -->
    <div class="grid gap-6 lg:grid-cols-4">
        <!-- Critical Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-red-50 to-orange-50 shadow-sm border border-red-200 overflow-hidden">
            <div class="border-b border-red-200 bg-red-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-red-900">🔴 Stok Kritis</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-red-600 text-white text-xs font-bold">8</span>
                </div>
                <p class="mt-1 text-xs text-red-700">Segera reorder barang</p>
            </div>
            <div class="space-y-3 p-4">
                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-red-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Keyboard RGB</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-003</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-semibold">2 unit</span>
                                <span class="text-xs text-gray-500">Min: 10</span>
                            </div>
                        </div>
                        <button class="text-red-600 hover:text-red-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-red-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Charger USB-C</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-087</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-semibold">1 unit</span>
                                <span class="text-xs text-gray-500">Min: 15</span>
                            </div>
                        </div>
                        <button class="text-red-600 hover:text-red-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="w-full py-2 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition">+ Lihat 6 lagi</button>
            </div>
        </div>

        <!-- Low Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-yellow-50 to-amber-50 shadow-sm border border-yellow-200 overflow-hidden">
            <div class="border-b border-yellow-200 bg-yellow-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-yellow-900">🟡 Stok Rendah</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-yellow-600 text-white text-xs font-bold">15</span>
                </div>
                <p class="mt-1 text-xs text-yellow-700">Pertimbangkan untuk reorder</p>
            </div>
            <div class="space-y-3 p-4">
                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-yellow-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Mouse Wireless</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-002</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">12 unit</span>
                                <span class="text-xs text-gray-500">Min: 15</span>
                            </div>
                        </div>
                        <button class="text-yellow-600 hover:text-yellow-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-yellow-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">HDMI Cable</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-045</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-semibold">18 unit</span>
                                <span class="text-xs text-gray-500">Min: 25</span>
                            </div>
                        </div>
                        <button class="text-yellow-600 hover:text-yellow-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="w-full py-2 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition">+ Lihat 13 lagi</button>
            </div>
        </div>

        <!-- Normal Stock Column -->
        <div class="rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 shadow-sm border border-green-200 overflow-hidden">
            <div class="border-b border-green-200 bg-green-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-green-900">🟢 Stok Normal</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-green-600 text-white text-xs font-bold">198</span>
                </div>
                <p class="mt-1 text-xs text-green-700">Stok mencukupi</p>
            </div>
            <div class="space-y-3 p-4">
                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-green-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Laptop Dell XPS</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-001</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold">45 unit</span>
                                <span class="text-xs text-gray-500">Min: 20</span>
                            </div>
                        </div>
                        <button class="text-green-600 hover:text-green-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-green-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Monitor LG 27"</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-004</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold">28 unit</span>
                                <span class="text-xs text-gray-500">Min: 15</span>
                            </div>
                        </div>
                        <button class="text-green-600 hover:text-green-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="w-full py-2 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition">+ Lihat 196 lagi</button>
            </div>
        </div>

        <!-- Overstocked Column -->
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 shadow-sm border border-blue-200 overflow-hidden">
            <div class="border-b border-blue-200 bg-blue-100 px-4 py-3">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-blue-900">🔵 Stok Berlebih</h3>
                    <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-600 text-white text-xs font-bold">26</span>
                </div>
                <p class="mt-1 text-xs text-blue-700">Stok melebihi maksimum</p>
            </div>
            <div class="space-y-3 p-4">
                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-blue-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Kabel LAN Cat6</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-089</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-semibold">150 unit</span>
                                <span class="text-xs text-gray-500">Max: 100</span>
                            </div>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Item Card -->
                <div class="rounded-lg bg-white p-3 shadow-sm border border-blue-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">Pita Isolasi</p>
                            <p class="text-xs text-gray-500 mt-1">Kode: BR-124</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-semibold">250 unit</span>
                                <span class="text-xs text-gray-500">Max: 200</span>
                            </div>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button class="w-full py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition">+ Lihat 24 lagi</button>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Rekomendasi Tindakan</h3>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                <p class="font-medium text-red-900">Urgent Reorder Needed</p>
                <p class="mt-2 text-sm text-red-700">8 barang memerlukan pemesanan segera untuk menghindari kehabisan stok.</p>
                <button class="mt-3 w-full rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">Buat PO Sekarang</button>
            </div>
            <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4">
                <p class="font-medium text-yellow-900">Consider Reordering</p>
                <p class="mt-2 text-sm text-yellow-700">15 barang stok rendah dan sebaiknya dipertimbangkan untuk dipesan dalam waktu dekat.</p>
                <button class="mt-3 w-full rounded-lg bg-yellow-600 px-3 py-2 text-xs font-medium text-white hover:bg-yellow-700">Preview PO</button>
            </div>
            <div class="rounded-lg bg-blue-50 border border-blue-200 p-4">
                <p class="font-medium text-blue-900">Optimize Overstocking</p>
                <p class="mt-2 text-sm text-blue-700">26 barang memiliki stok melebihi maksimum dan dapat dikurangi atau dipindahkan.</p>
                <button class="mt-3 w-full rounded-lg bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">Lihat Detail</button>
            </div>
        </div>
    </div>
</div>
@endsection
