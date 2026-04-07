@php
    $currentRoute = request()->route()->getName();
    $navClass = fn(string $route) => 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors '
        . ($currentRoute === $route ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white');
    $profileNavClass = 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors '
        . ($currentRoute === 'profile.show' ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white');
    $userNavClass = 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors '
        . (str_starts_with($currentRoute, 'admin.users.') ? 'bg-white/10 text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white');
@endphp

<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-56 bg-[#1e2333] text-white flex flex-col z-30
           -translate-x-full lg:translate-x-0 transition-transform duration-300">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10 shrink-0">
        <div class="w-9 h-9 rounded-lg bg-orange-500 flex items-center justify-center font-bold text-sm shrink-0">
            JTI
        </div>
        <div>
            <div class="font-bold text-sm leading-tight">JTISpot</div>
            <div class="text-xs text-gray-400">
                @can('admin') Portal Admin
                @elsecan('class_rep') Portal Ketua Kelas
                @else Portal Mahasiswa
                @endcan
            </div>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

        {{-- Main Global Links --}}
        <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-gray-400 hover:bg-white/10 hover:text-white">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Halaman Utama
        </a>
        <a href="{{ route('profile.show') }}" class="{{ $profileNavClass }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profil
        </a>
        
        <div class="h-px bg-white/10 my-3 mx-2"></div>

        {{-- Menu Admin --}}
        @can('admin')
            <a href="{{ route('admin.dashboard.home') }}" class="{{ $navClass('admin.dashboard.home') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.room.room') }}" class="{{ $navClass('admin.room.room') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Manajemen Ruang
            </a>
            <a href="{{ route('admin.schedules') }}" class="{{ $navClass('admin.schedules') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Semua Jadwal
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ $userNavClass }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengguna
            </a>
            <a href="#" class="{{ $navClass('admin.reports') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan
            </a>
            <a href="#" class="{{ $navClass('admin.settings') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
        @endcan

        {{-- Menu Student & Class Rep --}}
        @can('student')
            <a href="{{ route('student.dashboard.home') }}" class="{{ $navClass('student.dashboard.home') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            {{-- Pusat Aksi: khusus ketua kelas --}}
            @can('class_rep')
                <a href="#" class="{{ $navClass('student.action-center') }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Pusat Aksi
                </a>
            @endcan

            <a href="{{ route('student.schedules') }}" class="{{ $navClass('student.schedules') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Jadwal Kelas
            </a>
            <a href="#" class="{{ $navClass('student.reports') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan
            </a>
            <a href="#" class="{{ $navClass('student.settings') }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
        @endcan
    </nav>

    {{-- Profil User --}}
    <div class="px-3 py-4 border-t border-white/10 shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-orange-400 flex items-center justify-center text-white font-bold text-sm shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400 truncate">
                    @can('admin') 
                        Administrator
                    @elsecan('class_rep') 
                        @if(auth()->user()->classGroup)
                            {{ auth()->user()->classGroup->name }} &bull; Ketua Kelas
                        @else
                            Ketua Kelas
                        @endif
                    @else
                        @if(auth()->user()->classGroup)
                            {{ auth()->user()->classGroup->name }} &bull; Mahasiswa
                        @else
                            Mahasiswa
                        @endif
                    @endcan
                </div>
            </div>
            <div>
                <button type="button" onclick="document.getElementById('logout-modal').classList.remove('hidden')" class="p-2 -mr-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors shrink-0" title="Keluar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</aside>

<!-- Logout Modal -->
<div id="logout-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('logout-modal').classList.add('hidden')"></div>
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
                <button type="button" onclick="document.getElementById('logout-modal').classList.add('hidden')" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg transition-colors border-0">
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
