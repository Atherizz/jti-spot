<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                           <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5h-2v-5h2v5zm0-7h-2v-2h2v2zm5 7h-2v-5h2v5zm0-7h-2v-2h2v2z"/>
                        </svg>
                    </div>
                    <a href="/" class="text-xl font-bold text-indigo-900">
                        JTISpot
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 border-orange-500 text-sm font-medium leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                        Beranda
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Peta Ruang
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        Laporan
                    </a>
                </div>
            </div>

            <!-- Right Side Actions -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                <a href="{{ route('login') }}">
                    <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Check In
                    </button>
                </a>
                
                <button class="text-gray-400 hover:text-gray-500 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <div class="ml-2 relative">
                    <div class="w-8 h-8 rounded-full bg-orange-200 border-2 border-orange-300 overflow-hidden text-center flex items-center justify-center text-orange-700 font-bold">
                        U
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
