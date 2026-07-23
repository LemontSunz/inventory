<header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
    <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8 xl:px-10">
        
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
        <div class="ml-auto flex items-center gap-3">

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