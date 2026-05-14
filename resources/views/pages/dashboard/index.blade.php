@extends('layouts.app')

@section('title', 'Dashboard - LogistikPro')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Dashboard Warehouse</h2>
            <p class="mt-2 text-gray-600">Selamat datang kembali! Pantau stok dan aktivitas gudang Anda.</p>
        </div>
        <div class="flex gap-2">
            <button class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Refresh
            </button>
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Barang Baru
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Barang -->
        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Barang</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">1,247</p>
                    <p class="mt-2 text-xs text-green-600">+12% dari minggu lalu</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Masuk Hari Ini -->
        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Masuk Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">156</p>
                    <p class="mt-2 text-xs text-green-600">+8% dari hari lalu</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Keluar Hari Ini -->
        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Keluar Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">89</p>
                    <p class="mt-2 text-xs text-orange-600">-5% dari hari lalu</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stok Kritis -->
        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Kritis</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">12</p>
                    <p class="mt-2 text-xs text-red-600">Perlu ditindaklanjuti</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M7.08 6.47A9.002 9.002 0 0016.92 17.53M4.58 12a9.003 9.003 0 0114.84 0" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Recent Activities (spans 2 cols on lg) -->
        <div class="rounded-xl bg-white shadow-sm border border-gray-200 lg:col-span-2">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-semibold text-gray-900">Aktivitas Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">Barang Masuk PO-001</p>
                        <p class="text-sm text-gray-500">Diterima oleh Admin</p>
                    </div>
                    <p class="text-xs text-gray-500">10 menit lalu</p>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">Stok Barang A123 Disetujui</p>
                        <p class="text-sm text-gray-500">Update dari sistem</p>
                    </div>
                    <p class="text-xs text-gray-500">25 menit lalu</p>
                </div>
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">Barang Keluar SO-045</p>
                        <p class="text-sm text-gray-500">Dikirim ke customer</p>
                    </div>
                    <p class="text-xs text-gray-500">1 jam lalu</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-xl bg-white shadow-sm border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-semibold text-gray-900">Aksi Cepat</h3>
            </div>
            <div class="space-y-2 p-6">
                <a href="{{ route('warehouse.inbound.index') }}" class="flex items-center gap-3 rounded-lg bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700 hover:bg-blue-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Barang Masuk
                </a>
                <a href="{{ route('warehouse.outbound.index') }}" class="flex items-center gap-3 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700 hover:bg-green-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Barang Keluar
                </a>
                <a href="{{ route('warehouse.items.index') }}" class="flex items-center gap-3 rounded-lg bg-purple-50 px-4 py-3 text-sm font-medium text-purple-700 hover:bg-purple-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Data Barang
                </a>
                <a href="{{ route('warehouse.stock.index') }}" class="flex items-center gap-3 rounded-lg bg-amber-50 px-4 py-3 text-sm font-medium text-amber-700 hover:bg-amber-100 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kelola Stok
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
