<header class="w-full border-b border-slate-200 bg-white">
    <div class="flex h-16 items-center justify-between px-6 lg:px-8">
        
        <!-- Kiri: Logo -->
        <a href="#" class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-600 text-white font-bold">
                PI
            </div>

            <div>
                <h1 class="text-sm font-semibold text-slate-900">
                    Project Inventory
                </h1>
                <p class="text-xs text-slate-500">
                    Inventory Management System
                </p>
            </div>
        </a>

        <!-- Kanan: Menu -->
        <div class="flex items-center gap-3">

            <!-- Search -->
            <div class="relative hidden lg:block">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.3-4.3"/>
                </svg>

                <input 
                    type="search"
                    placeholder="Cari data..."
                    class="h-10 w-80 rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm outline-none transition focus:border-sky-500 focus:bg-white focus:ring-2 focus:ring-sky-100">
            </div>

            <!-- Notifikasi -->
            <button class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </button>

            <!-- User -->
            <button class="flex items-center gap-3 rounded-xl px-2 py-1 hover:bg-slate-50">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 text-sm font-semibold text-sky-700">
                    SA
                </div>

                <div class="hidden lg:block text-left">
                    <p class="text-sm font-medium text-slate-900">
                        Solehudin
                    </p>
                    <p class="text-xs text-slate-500">
                        Administrator
                    </p>
                </div>
            </button>

        </div>

    </div>
</header>