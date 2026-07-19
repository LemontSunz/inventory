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
            <form method="GET" action="{{ route('dashboard') }}">
                <button type="submit" class="group inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm border border-gray-300 hover:bg-gray-50 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Refresh
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Barang -->
        <div class="rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Barang</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalBarang }}</p>
                    <p class="mt-2 text-xs text-gray-500">Jumlah item terdaftar</p>
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
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $barangMasukHariIni }}</p>
                    <p class="mt-2 text-xs text-gray-500">Transaksi barang masuk</p>
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
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $barangKeluarHariIni }}</p>
                    <p class="mt-2 text-xs text-gray-500">Transaksi barang keluar</p>
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
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stokKritis }}</p>
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

    <!-- Charts -->
    <div class="grid gap-6">
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Grafik Transaksi Barang</h3>
                    <p class="mt-1 text-sm text-gray-500">Tampilan 12 bulan terakhir untuk transaksi barang masuk dan keluar.</p>
                </div>
                <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                    <span class="group inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                        Barang Masuk
                    </span>
                    <span class="group inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                        <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                        Barang Keluar
                    </span>
                </div>
            </div>

            <div class="h-[360px]">
                <canvas id="activityChart" class="h-full w-full"></canvas>
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
                @forelse($activities as $activity)
                    <div class="flex items-center gap-4 px-6 py-4">
                        @if($activity->type === 'masuk')
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Barang Masuk {{ $activity->code }}</p>
                                <p class="text-sm text-gray-500">{{ $activity->description ?? 'Diterima ke gudang' }}</p>
                            </div>
                        @else
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                                <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Barang Keluar {{ $activity->code }}</p>
                                <p class="text-sm text-gray-500">{{ $activity->description ?? 'Dikirim ke cabang' }}</p>
                            </div>
                        @endif
                        <p class="text-xs text-gray-500">{{ $activity->activity_date->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <p class="text-sm text-gray-500">Belum ada aktivitas terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="rounded-xl bg-white shadow-sm border border-gray-200">
            <div class="border-b border-gray-200 px-6 py-4">
                <h3 class="font-semibold text-gray-900">Aksi Cepat</h3>
            </div>
            <div class="space-y-2 p-6">
                <a href="{{ route('barang-masuk.index') }}" class="flex items-center gap-3 rounded-lg bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700 hover:bg-blue-100 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Barang Masuk
                </a>
                <a href="{{ route('warehouse.outbound.index') }}" class="flex items-center gap-3 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700 hover:bg-green-100 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    Barang Keluar
                </a>
                <a href="{{ route('warehouse.stock.index') }}" class="flex items-center gap-3 rounded-lg bg-amber-50 px-4 py-3 text-sm font-medium text-amber-700 hover:bg-amber-100 transition cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Laporan Stok Barang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('activityChart');
            if (!ctx) {
                return;
            }

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            data: @json($chartMasukData),
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(59, 130, 246, 0.18)',
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        },
                        {
                            label: 'Barang Keluar',
                            data: @json($chartKeluarData),
                            borderColor: '#f97316',
                            backgroundColor: 'rgba(249, 115, 22, 0.18)',
                            borderWidth: 3,
                            tension: 0.35,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: '#f97316',
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#334155',
                                boxWidth: 12,
                                padding: 20,
                            },
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#ffffff',
                            bodyColor: '#e2e8f0',
                            mode: 'index',
                            intersect: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    weight: '500',
                                },
                            },
                        },
                        y: {
                            grid: {
                                color: 'rgba(148, 163, 184, 0.18)',
                            },
                            ticks: {
                                color: '#64748b',
                                beginAtZero: true,
                            },
                        },
                    },
                },
            });
        });
    </script>
@endsection

