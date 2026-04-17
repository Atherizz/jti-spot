@extends('layouts.dashboard')

@section('title', 'Pusat Manajemen Data')

@section('content')

    {{-- Editorial Formal Hero --}}
    <div class="editorial-panel bg-white mb-8 stagger-1 flex flex-col md:flex-row overflow-hidden relative">
        <!-- Abstract geometric decoration (softer) -->
        <div class="absolute right-0 top-0 w-96 h-96 bg-orange-50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>

        <div class="flex-1 p-8 md:p-10 border-b md:border-b-0 md:border-r border-ink/5 relative z-10 w-full">
            <div class="flex items-center gap-2 mb-4">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Sistem Normal &bull; Auto-Sync Aktif</span>
            </div>
            
            <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight leading-tight mb-4 text-ink">
                Pusat Manajemen Data
            </h1>
            
            <p class="text-base max-w-xl text-ink/60">
                Selamat datang kembali, <span class="font-semibold text-ink">{{ auth()->user()->name }}</span>. 
                Sistem ini memungkinkan Anda memantau seluruh armada ruang kelas dan pergerakan jadwal kampus secara terpusat.
            </p>
        </div>

        <div class="w-full md:w-72 flex flex-col relative z-10">
            <div class="flex-1 p-8 border-b border-ink/5 bg-gray-50/50 backdrop-blur-sm relative group overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[11px] font-semibold uppercase tracking-widest text-ink/40 mb-1">Kepadatan Jadwal Harian</p>
                    <div class="flex items-end gap-1">
                        <p class="font-display text-4xl font-bold text-ink">82</p>
                        <p class="text-xl font-medium text-ink/40 pb-1">%</p>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-8 bg-emerald-50/50 relative overflow-hidden group border-b md:border-b-0 border-ink/5">
                <div class="relative z-10">
                    <p class="text-[11px] font-semibold uppercase tracking-widest text-emerald-700 mb-1">Ruang Standby Sekarang</p>
                    <div class="flex items-end gap-1">
                        <p class="font-display text-4xl font-bold text-emerald-700">18</p>
                        <p class="text-sm font-medium text-emerald-700/60 pb-1 mb-0.5">ruang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Formal Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stagger-2">
        
        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-ink/5 flex items-center justify-center text-ink/60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">
                    +2 Bulan Ini
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Total Ruang Kelas</p>
            <p class="font-display text-3xl font-bold text-ink">42</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-orange-50 text-orange-600 border border-orange-100">
                    Semester Genap
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Jadwal Aktif Berjalan</p>
            <p class="font-display text-3xl font-bold text-ink">1,248</p>
        </div>

        <div class="editorial-panel bg-white p-6 relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-orange-100 text-orange-700">
                    Perhatian
                </span>
            </div>
            <p class="text-sm font-medium text-ink/50 mb-1">Peringatan Konflik</p>
            <p class="font-display text-3xl font-bold text-orange-600">3</p>
        </div>

        <div class="editorial-panel bg-ink text-white p-6 flex flex-col justify-center items-center text-center cursor-pointer hover:bg-ink/90 transition-colors group">
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <h3 class="font-display text-lg font-bold tracking-tight">Entri Jadwal Baru</h3>
            <p class="text-xs text-white/50 mt-1">Tambahkan sesi baru manual</p>
        </div>

    </div>

    {{-- Modern Formal Table --}}
    <div class="editorial-panel overflow-hidden stagger-3 mb-12">
        
        {{-- Table Header Banner --}}
        <div class="p-6 md:p-8 bg-white border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="font-display text-xl font-bold tracking-tight text-ink mb-1">Matrix Pengendalian Aset</h2>
                <p class="text-sm text-gray-500">Ketersediaan ruang aktual dan penyelesaian anomali penjadwalan.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" placeholder="Cari data ruang..." class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-ink/10 focus:bg-white transition-colors">
                </div>
                <button class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 9v8l-4-3v-5L3 4z" /></svg>
                    Saring Data
                </button>
            </div>
        </div>

        {{-- Table Data --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Identifikasi</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Kelas/Dosen Pengampu</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Durasi Waktu</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Sistem Status</th>
                        <th class="px-6 py-4 font-display text-xs font-semibold text-gray-500 tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    
                    {{-- Row 1 --}}
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">RT-01</div>
                            <div class="text-xs text-gray-500 mt-0.5">Lantai 2 &bull; GD. A</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">Web Programming</div>
                            <div class="text-xs text-gray-500 mt-0.5">Budi Santoso</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-gray-50 border border-gray-100 text-xs font-medium text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                07:00 &mdash; 10:30
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                Terpakai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-ink hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">RT-02</div>
                            <div class="text-xs text-gray-500 mt-0.5">Lantai 2 &bull; GD. A</div>
                        </td>
                        <td class="px-6 py-4 text-gray-300 font-medium">&mdash;</td>
                        <td class="px-6 py-4 text-gray-300 font-medium">&mdash;</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 border border-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Standby
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-ink hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Row 3 : CONFLICT --}}
                    <tr class="border-b border-orange-100 bg-orange-50/30 hover:bg-orange-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-orange-900">RT-05</div>
                            <div class="text-xs text-orange-600/70 mt-0.5">Lantai 1 &bull; GD. B</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">Data Structures</div>
                            <div class="text-xs text-gray-500 mt-0.5">Sari Rahayu</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-white border border-red-200 text-xs font-medium text-red-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                09:00 &mdash; 12:00
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 border border-orange-200 text-orange-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                Konflik Jadwal
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="px-3 py-1.5 text-xs font-medium bg-white border border-gray-200 rounded-lg hover:border-gray-300 hover:bg-gray-50 text-ink transition-all shadow-sm">
                                Tinjau
                            </button>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">LPR-01</div>
                            <div class="text-xs text-gray-500 mt-0.5">Lab Pemrograman 1</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-ink">Pengembangan Mobile</div>
                            <div class="text-xs text-gray-500 mt-0.5">Ahmad Husain</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-gray-50 border border-gray-100 text-xs font-medium text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                13:00 &mdash; 16:00
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                Terpakai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-ink hover:bg-gray-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-between items-center text-sm">
            <span class="text-gray-500">Data 1 &mdash; 4 dari 42</span>
            
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <div class="flex items-center gap-1">
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-ink text-white font-medium text-sm shadow-sm">1</button>
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-600 font-medium text-sm transition-colors">2</button>
                    <button class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-600 font-medium text-sm transition-colors">3</button>
                </div>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>

    </div>

@endsection

