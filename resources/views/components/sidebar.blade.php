<aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-40 w-20 bg-gradient-to-b from-slate-900 to-slate-800 text-white shadow-lg transition-all duration-300 md:w-64 md:relative md:inset-auto">
    <!-- Brand Section -->
    <div class="flex h-20 items-center border-b border-slate-700 px-4 md:px-6">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Project Inventory" class="hidden h-6 w-auto md:block">
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-2 overflow-y-auto px-2 py-6 md:px-4">
        
        <!-- Dashboard -->
        <div class="space-y-2">
            <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Menu Utama</p>
            <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="hidden md:inline font-medium">Dashboard</span>
            </a>
        </div>

        <!-- Warehouse Management -->
        <div class="space-y-2">
            <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Manajemen Gudang</p>
            
            <!-- Kelola Data Barang -->
            <a href="{{ route('barang.index') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group" title="Kelola Data Barang">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-emerald-500/20 text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Kelola Data Barang</span>
            </a>

            <!-- Kelola Barang Masuk -->
            <a href="{{ route('warehouse.inbound.index') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group" title="Kelola Barang Masuk">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-blue-500/20 text-blue-400 group-hover:bg-blue-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Kelola Barang Masuk</span>
            </a>

            <!-- Kelola Barang Keluar -->
            <a href="{{ route('warehouse.outbound.index') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group" title="Kelola Barang Keluar">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-orange-500/20 text-orange-400 group-hover:bg-orange-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Kelola Barang Keluar</span>
            </a>

            <!-- Kelola Stok Barang -->
            <a href="{{ route('warehouse.stock.index') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group" title="Kelola Stok Barang">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-purple-500/20 text-purple-400 group-hover:bg-purple-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Kelola Stok Barang</span>
            </a>

            <!-- Mengelola Stok Barang (dengan view berbeda) -->
            <a href="{{ route('warehouse.stock-management.index') }}" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group" title="Mengelola Stok Barang">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-pink-500/20 text-pink-400 group-hover:bg-pink-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Mengelola Stok Barang</span>
            </a>
        </div>

        <!-- Reports Section -->
        <div class="space-y-2">
            <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Laporan</p>
            <a href="#" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-red-500/20 text-red-400 group-hover:bg-red-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Laporan Stok</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div class="space-y-2">
            <p class="hidden px-3 text-xs font-semibold uppercase tracking-widest text-slate-400 md:block">Pengaturan</p>
            <a href="#" class="sidebar-item flex items-center gap-4 rounded-lg px-3 py-3 text-slate-300 transition duration-200 hover:bg-slate-700 hover:text-white group">
                <div class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded bg-gray-500/20 text-gray-400 group-hover:bg-gray-500 group-hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="hidden md:inline font-medium text-sm">Pengaturan</span>
            </a>
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
<div id="sidebarOverlay" class="fixed inset-0 z-30 hidden bg-black/50 md:hidden" onclick="document.getElementById('sidebar').classList.toggle('translate-x-full')"></div>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });
</script>
