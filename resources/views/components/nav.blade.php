<header class="w-full border-b border-slate-200 bg-white">
    <div class="flex h-24 items-center justify-between px-6 lg:px-8">
        
        <!-- Kiri: Logo -->
        <a href="#" class="flex flex-col items-center gap-2 cursor-pointer">
            <img src="{{ asset('images/crown-horeca.jpg') }}" alt="Crown Horeca Logo" class="h-12 w-40 rounded-full object-cover">

            <div class="text-left">
                <h1 class="text-l font-serif font-bold text-slate-900 leading-tight">
                    PT. Karya Makmur Mesindo
                </h1>
            </div>
        </a>

        <!-- Kanan: Menu -->
        <div class="flex items-center gap-3">

            <!-- Search - Hidden on login page -->
            @if(!Route::is('login'))
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
            @endif

            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <!-- User Account Dropdown -->
                <div class="relative">
                    <button type="button" onclick="document.getElementById('userDropdown').classList.toggle('hidden')" class="flex items-center gap-3 rounded-lg px-3 py-2 cursor-pointer transition hover:bg-slate-100">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-sky-100 text-sm font-semibold text-sky-700">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>

                        <div class="hidden lg:block text-left">
                            <p class="text-sm font-medium text-slate-900">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ auth()->user()->role === 'manager' ? 'Manager' : 'Admin Gudang' }}
                            </p>
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white shadow-lg z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-100 cursor-pointer">
                            Edit Profil
                        </a>
                        <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer">
                            Logout
                        </button>
                    </div>
                </div>

                <!-- Close dropdown when clicking outside -->
                <script>
                    document.addEventListener('click', function(event) {
                        const dropdown = document.getElementById('userDropdown');
                        const userButton = event.target.closest('button[onclick*="userDropdown"]');
                        if (!dropdown.contains(event.target) && !userButton) {
                            dropdown.classList.add('hidden');
                        }
                    });
                </script>
            @else
                <!-- Login button - Hidden on login page -->
                @if(!Route::is('login'))
                    <a href="{{ route('login') }}" class="group inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 cursor-pointer">
                        Login
                    </a>
                @endif
            @endauth

        </div>

    </div>
</header>