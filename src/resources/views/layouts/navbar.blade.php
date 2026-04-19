<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo JTISpot" class="h-[40px] w-auto hover:opacity-90 transition-opacity">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out {{ request()->is('/') ? 'border-orange-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Beranda
                    </a>
                    <a href="{{ route('map') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out {{ request()->routeIs('map') ? 'border-orange-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Peta Ruang
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out {{ request()->is('laporan*') ? 'border-orange-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Laporan
                    </a>
                </div>
            </div>

            <!-- Right Side Actions (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    @php
                        $dashboardRoute = auth()->user()->can('admin') ? route('admin.dashboard.home') : route('student.dashboard.home');
                    @endphp
                    <div class="ml-3 relative z-50">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="flex items-center gap-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 rounded-full transition-all p-1 pr-2 hover:bg-gray-50 border border-transparent">
                            <div class="w-8 h-8 rounded-full bg-orange-500 overflow-hidden text-center flex items-center justify-center text-white font-bold text-sm shrink-0 pointer-events-none">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-700 pointer-events-none">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50 transition-all">
                            <a href="{{ $dashboardRoute }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-orange-600 transition-colors">Dashboard</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-orange-600 transition-colors">Profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <button type="button" onclick="document.getElementById('navbar-logout-modal').classList.remove('hidden')" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                Logout
                            </button>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm hover:shadow">
                            Login
                        </button>
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->is('/') ? 'border-orange-500 text-orange-700 bg-orange-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Beranda
            </a>
            <a href="{{ route('map') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('map') ? 'border-orange-500 text-orange-700 bg-orange-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Peta Ruang
            </a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->is('laporan*') ? 'border-orange-500 text-orange-700 bg-orange-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Laporan
            </a>
        </div>
        <div class="pt-4 pb-4 border-t border-gray-200">
            @auth
                @php
                    $dashboardRoute = auth()->user()->can('admin') ? route('admin.dashboard.home') : route('student.dashboard.home');
                @endphp
                <div class="flex items-center px-4 mb-4 gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-500 overflow-hidden text-center flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-base font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="px-4 space-y-2 mt-3">
                    <a href="{{ $dashboardRoute }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        Dashboard
                    </a>
                    <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        Profil
                    </a>
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.add('hidden'); document.getElementById('navbar-logout-modal').classList.remove('hidden')" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors">
                        Logout
                    </button>
                </div>
            @else
                <div class="flex items-center px-4 gap-4">
                    <a href="{{ route('login') }}" class="w-full">
                        <button class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Login
                        </button>
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Navbar Logout Modal -->
@auth
<div id="navbar-logout-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('navbar-logout-modal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-xl shadow-xl w-[90%] md:w-full mx-auto p-6 overflow-hidden transform transition-all" style="max-width: 380px;">
        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Logout</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin keluar dari aplikasi?</p>

            <div class="flex flex-row items-center gap-3 w-full">
                <button type="button" onclick="document.getElementById('navbar-logout-modal').classList.add('hidden')" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg transition-colors border-0">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1 m-0 w-full" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.classList.add('opacity-75', 'cursor-not-allowed'); btn.innerHTML = 'Keluar...';">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors border-0">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth

