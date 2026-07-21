<aside id="sidebar" class="sidebar fixed left-0 top-20 z-40 flex h-[calc(100vh-5rem)] w-72 -translate-x-full flex-col border-r border-slate-800 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-slate-100 shadow-2xl transition-transform duration-300 md:translate-x-0">
    <!-- Navigation -->
    <nav class="flex-1 space-y-4 overflow-y-auto px-3 py-6">

        <!-- Dashboard -->
        <div class="space-y-2">
            <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-500 md:block">Menu Utama</p>
            <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 text-slate-300 transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-purple-700 text-white shadow-xl' : 'hover:bg-purple-700 hover:text-white' }} cursor-pointer">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="hidden md:inline font-medium">Dashboard</span>
            </a>
        </div>

        <!-- Warehouse Management -->
        <div class="space-y-2">
            @if(auth()->user()->role === 'manager')
                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">MENU MANAJEMEN GUDANG</p>
                <a href="{{ route('barang.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('barang.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Data Barang">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-emerald-500/20 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Data Barang</span>
                </a>

                <a href="{{ route('cabang.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('cabang.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Data Cabang">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-indigo-500/20 text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 7h18M3 17h18" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Data Cabang</span>
                </a>

                <a href="{{ route('lokasi-rak.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('lokasi-rak.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-purple-700 hover:text-white group cursor-pointer" title="Lokasi Rak">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Lokasi Rak</span>
                </a>

                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">MENU LAPORAN</p>
                <a href="{{ route('barang-masuk.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('barang-masuk.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Laporan Barang Masuk">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-blue-500/20 text-blue-400 group-hover:bg-blue-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Laporan Barang Masuk</span>
                </a>

                <a href="{{ route('warehouse.outbound.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('warehouse.outbound.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Laporan Barang Keluar">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-orange-500/20 text-orange-400 group-hover:bg-orange-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Laporan Barang Keluar</span>
                </a>

                @php $stockActive = request()->routeIs('warehouse.stock.*') ? 'bg-purple-700 text-white' : 'text-slate-300'; @endphp
                <a href="{{ route('warehouse.stock.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ $stockActive }} transition duration-200 hover:bg-purple-700 hover:text-white group cursor-pointer" title="Laporan Stok Barang">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Laporan Stok Barang</span>
                </a>

                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">MENU MANAJEMEN PENGGUNA</p>
                <a href="{{ route('users.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('users.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-purple-700 hover:text-white group cursor-pointer" title="Kelola Pengguna">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-lime-500/20 text-lime-400 group-hover:bg-lime-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm1 13H7a5 5 0 00-5 5v1h18v-1a5 5 0 00-5-5z" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Kelola Pengguna</span>
                </a>
            @else
                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Manajemen Gudang</p>

                <!-- Kelola Data Barang -->
                <a href="{{ route('barang.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('barang.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Kelola Data Barang">

                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-emerald-500/20 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Data Barang</span>
                </a>

                <!-- Data Cabang -->
                <a href="{{ route('cabang.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('cabang.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Data Cabang">

                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-indigo-500/20 text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 7h18M3 17h18" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Data Cabang</span>
                </a>

                <!-- Kelola Barang Masuk -->

                <a href="{{ route('barang-masuk.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('barang-masuk.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Kelola Barang Masuk">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-blue-500/20 text-blue-400 group-hover:bg-blue-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Barang Masuk</span>
                </a>

                <!-- Kelola Barang Keluar -->
                <a href="{{ route('warehouse.outbound.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('warehouse.outbound.*') ? 'bg-purple-700 text-white shadow-xl' : 'text-slate-300' }} transition duration-200 hover:bg-slate-700 hover:text-white group cursor-pointer" title="Kelola Barang Keluar">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-orange-500/20 text-orange-400 group-hover:bg-orange-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Barang Keluar</span>
                </a>

                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Gudang</p>
                <a href="{{ route('lokasi-rak.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ request()->routeIs('lokasi-rak.*') ? 'bg-purple-700 text-white' : 'text-slate-300' }} transition duration-200 hover:bg-purple-700 hover:text-white group cursor-pointer" title="Lokasi Rak">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Lokasi Rak</span>
                </a>

                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Laporan</p>
                <!-- Kelola Stok Barang (CRUD) -->
                @php $stockActive = request()->routeIs('warehouse.stock.*') ? 'bg-purple-700 text-white' : 'text-slate-300'; @endphp
                <a href="{{ route('warehouse.stock.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 {{ $stockActive }} transition duration-200 hover:bg-purple-700 hover:text-white group cursor-pointer" title="Laporan Stok Barang">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Stok Barang</span>
                </a>
                <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Armada</p>
                <!-- Armada -->
                <a href="{{ route('armada.drivers.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 text-slate-300 transition duration-200 {{ request()->routeIs('armada.drivers.*') ? 'bg-purple-700 text-white shadow-xl' : 'hover:bg-purple-700 hover:text-white' }} cursor-pointer" title="Armada Driver">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-cyan-500/15 text-cyan-300 {{ request()->routeIs('armada.drivers.*') ? 'bg-cyan-500/25' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m3-6V6a2 2 0 00-2-2H8a2 2 0 00-2 2v5m3 0h6" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Pengemudi</span>
                </a>

                <!-- Kendaraan -->
                <a href="{{ route('kendaraan.index') }}" class="sidebar-item flex items-center gap-4 rounded-xl px-3 py-3 text-slate-300 transition duration-200 {{ request()->routeIs('kendaraan.*') ? 'bg-purple-700 text-white shadow-xl' : 'hover:bg-purple-700 hover:text-white' }} cursor-pointer" title="Kelola Kendaraan">
                    <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-sky-500/15 text-sky-300 {{ request()->routeIs('kendaraan.*') ? 'bg-sky-500/25' : '' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l5-5 5 5m-5-5v12m5-2h4m0 0v-4m0 4l-2 2" />
                        </svg>
                    </div>
                    <span class="hidden md:inline font-medium text-sm">Kendaraan</span>
                </a>
            @endif

        </div>



    </nav>

    <!-- Footer in Sidebar -->
    <div class="border-t border-slate-700 px-2 py-4 md:px-4">
        <div class="flex items-center gap-3 rounded-lg bg-slate-800/50 p-3">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-500 text-white text-sm font-bold">
                A
            </div>
            <div class="hidden md:block">
                <p class="text-xs font-semibold text-white">Admin</p>
                <p class="text-xs text-slate-400">Manajer Gudang</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-black/50 md:hidden cursor-pointer" onclick="document.getElementById('sidebar').classList.toggle('translate-x-full')"></div>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
        overlay.classList.toggle('hidden');
    });
</script>