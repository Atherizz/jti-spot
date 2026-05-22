@php
    $currentRoute = request()->route()->getName();
    $navClass = fn(string $route) => 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 '
        . ($currentRoute === $route ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-gray-400 hover:bg-white/5 hover:text-white');
    $profileNavClass = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 '
        . ($currentRoute === 'profile.show' ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-gray-400 hover:bg-white/5 hover:text-white');
    $userNavClass = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 '
        . (str_starts_with($currentRoute, 'admin.users.') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-gray-400 hover:bg-white/5 hover:text-white');
    // Aktif untuk semua halaman di bawah /student/action/*
    $actionNavClass = 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 '
        . (str_starts_with($currentRoute, 'student.action.') ? 'bg-white/10 text-white shadow-sm ring-1 ring-white/10' : 'text-gray-400 hover:bg-white/5 hover:text-white');
@endphp

<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-60 bg-ink text-white flex flex-col z-30
           -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-2xl lg:shadow-none border-r border-white/5 overflow-hidden">
    
    {{-- Elegant Background Texture --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent 70%);"></div>

    {{-- Logo --}}
    <div class="flex flex-col items-start gap-2.5 px-6 py-6 border-b border-white/10 shrink-0 relative z-10">
        <a href="/" class="block">
            <img src="{{ asset('images/logo3.png') }}" alt="Logo JTISpot" class="h-10 md:h-[45px] w-auto hover:opacity-90 transition-opacity">        </a>
        <div>
            <div class="text-[10px] font-semibold uppercase tracking-widest text-orange-300/80">
                @can('admin') Sistem Admin
                @elsecan('class_rep') Portal Kelas
                @else Portal Mahasiswa
                @endcan
            </div>
        </div>
    </div>

    {{-- Navigasi --}}
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto relative z-10 custom-scrollbar">

        {{-- Main Global Links --}}
        <a href="/" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 text-gray-400 hover:bg-white/5 hover:text-white">
            <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Halaman Utama
        </a>
        <a href="{{ route('profile.show') }}" class="{{ $profileNavClass }}">
            <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profil
        </a>
        
        <div class="h-px bg-white/5 my-4 mx-2"></div>

        {{-- Menu Admin --}}
        @can('admin')
            <div class="px-3 mb-2 font-display text-[10px] font-semibold uppercase tracking-widest text-white/40">Manajemen Aset</div>
            <a href="{{ route('admin.dashboard.home') }}" class="{{ $navClass('admin.dashboard.home') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dasbor
            </a>
            <a href="{{ route('admin.room.room') }}" class="{{ $navClass('admin.room.room') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Manajemen Ruang
            </a>
            <a href="{{ route('admin.class-groups.index') }}" class="{{ $navClass('admin.class-groups.index') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Manajemen Kelas
            </a>
            <a href="{{ route('admin.schedules') }}" class="{{ $navClass('admin.schedules') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Semua Jadwal
            </a>
            
            <div class="h-px bg-white/5 my-4 mx-2"></div>
            <div class="px-3 mb-2 font-display text-[10px] font-semibold uppercase tracking-widest text-white/40">Administrasi</div>
            
            <a href="{{ route('admin.users.index') }}" class="{{ $userNavClass }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengguna
            </a>
            <a href="#" class="{{ $navClass('admin.reports') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan
            </a>
            <a href="#" class="{{ $navClass('admin.settings') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
        @endcan
        
        {{-- Menu Student & Class Rep --}}
        @can('student')
            <div class="px-3 mb-2 font-display text-[10px] font-semibold uppercase tracking-widest text-white/40">Akademik</div>
            <a href="{{ route('student.dashboard.home') }}" class="{{ $navClass('student.dashboard.home') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dasbor
            </a>

            @can('class_rep')
                {{-- Pusat Aksi: hanya tersedia untuk ketua kelas --}}
                <a href="{{ route('student.action.center') }}" class="{{ $actionNavClass }}">
                    <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Pusat Aksi
                </a>
            @endcan

            <a href="{{ route('student.schedules') }}" class="{{ $navClass('student.schedules') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Jadwal Kelas
            </a>
            
            <div class="h-px bg-white/5 my-4 mx-2"></div>
            <div class="px-3 mb-2 font-display text-[10px] font-semibold uppercase tracking-widest text-white/40">Aktivitas</div>
            
            <a href="{{ route('student.activity.log') }}" class="{{ $navClass('student.activity.log') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Log Crowdsourcing
            </a>
            <a href="#" class="{{ $navClass('student.settings') }}">
                <svg class="w-5 h-5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Pengaturan
            </a>
        @endcan
    </nav>

    {{-- Profil User (Bottom Dock) --}}
    <div class="px-4 py-4 border-t border-white/10 shrink-0 relative z-10 bg-white/5 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white text-ink flex items-center justify-center font-bold text-sm shrink-0 shadow-sm border border-gray-200">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-[11px] font-medium text-gray-400 truncate">
                    @can('admin') 
                        Administrator Utama
                    @elsecan('class_rep') 
                        @if(auth()->user()->classGroup)
                            {{ auth()->user()->classGroup->name }} &bull; Perwakilan Kelas
                        @else
                            Perwakilan Kelas
                        @endif
                    @else
                        @if(auth()->user()->classGroup)
                            {{ auth()->user()->classGroup->name }} &bull; MHS
                        @else
                            Mahasiswa
                        @endif
                    @endcan
                </div>
            </div>
            <div>
                <button type="button" onclick="document.getElementById('logout-modal').classList.remove('hidden')" class="p-2 -mr-1 text-gray-400 hover:text-red-400 hover:bg-white/10 rounded-xl transition-colors shrink-0 group" title="Keluar">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</aside>

<!-- Logout Modal (Editorial Style) -->
<div id="logout-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-ink/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('logout-modal').classList.add('hidden')"></div>
    <div class="relative editorial-panel bg-white shadow-2xl w-[90%] md:w-full mx-auto p-8 overflow-hidden transform transition-all" style="max-width: 400px;">
        <!-- Decorative abstract background -->
        <div class="absolute right-0 top-0 w-32 h-32 bg-red-50 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        
        <div class="flex flex-col items-center text-center relative z-10">
            <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mb-5 ring-4 ring-white border border-red-100">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <h3 class="font-display text-2xl font-bold text-ink mb-2">Konfirmasi Keluar</h3>
            <p class="text-sm font-medium text-gray-500 mb-8">Apakah Anda yakin ingin mengakhiri sesi dan keluar dari sistem JTI-Spot?</p>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <button type="button" onclick="document.getElementById('logout-modal').classList.add('hidden')" class="w-full sm:w-auto flex-1 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-ink text-sm font-semibold rounded-xl transition-colors border border-gray-200">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto flex-1 m-0" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.classList.add('opacity-75', 'cursor-not-allowed'); btn.innerHTML = 'Memproses...';">
                    @csrf
                    <button type="submit" class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                        Ya, Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

