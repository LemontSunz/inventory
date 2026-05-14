<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-xl shadow-sm">
    <div class="mx-auto flex h-16 max-w-[1400px] items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">

            <div class="hidden sm:block">
                <p class="text-sm font-semibold text-slate-900">Project Inventory</p>
                <p class="text-xs text-slate-500">Monitoring stok, supplier, dan laporan nonstop.</p>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-end gap-3">
            <label class="relative hidden md:block w-full max-w-md">
                <span class="sr-only">Search inventory</span>
                <input id="globalSearch" type="search" placeholder="Cari produk, supplier, project..." class="h-11 w-full rounded-2xl border border-slate-200 bg-white px-4 pr-12 text-sm text-slate-900 shadow-sm outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100" />
                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-400">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </span>
            </label>

            <button class="hidden h-11 items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 md:flex">
                <svg class="h-4 w-4 text-sky-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14m7-7H5" />
                </svg>
                Tambah Item
            </button>

            <button class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <span class="sr-only">Notifikasi</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </button>

            <button class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <span class="sr-only">User menu</span>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-100 text-sm font-semibold text-slate-700">AI</span>
            </button>
        </div>
    </div>
</header>
