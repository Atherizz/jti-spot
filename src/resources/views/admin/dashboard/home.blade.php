@extends('layouts.dashboard')

@section('title', 'Pusat Manajemen Data')

@section('content')

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-700 via-indigo-600 to-sky-600 shadow-lg mb-6">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-white/8 blur-2xl"></div>
        <div class="absolute -bottom-20 -left-12 w-52 h-52 rounded-full bg-sky-200/20 blur-2xl"></div>

        <div class="relative p-6 sm:p-8 lg:p-9 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div>
                <p class="text-xs font-semibold tracking-[0.2em] uppercase text-indigo-200 mb-2">Dashboard Admin</p>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight">Pusat Manajemen Data</h1>
                <p class="text-sm text-indigo-100 mt-2 max-w-2xl">Selamat datang, {{ auth()->user()->name }}.<br>Kelola ruangan dan jadwal kampus dengan efisien.</p>

                <div class="flex flex-wrap items-center gap-2 mt-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/15 text-white border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>
                        Sistem Normal
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-white/10 text-indigo-100 border border-white/20">
                        Update Terakhir 2 Menit Lalu
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 w-full max-w-sm">
                <div class="rounded-2xl bg-indigo-200/35 border border-indigo-100/55 p-3.5 backdrop-blur-sm shadow-[0_8px_20px_rgba(99,102,241,0.12),inset_0_1px_0_rgba(255,255,255,0.35)]">
                    <p class="text-[11px] uppercase tracking-wider text-white/85">Pengguna Aktif Hari Ini</p>
                    <p class="text-2xl font-extrabold text-white mt-1">82%</p>
                </div>
                <div class="rounded-2xl bg-emerald-200/35 border border-emerald-100/60 p-3.5 backdrop-blur-sm shadow-[0_8px_20px_rgba(16,185,129,0.12),inset_0_1px_0_rgba(255,255,255,0.35)]">
                    <p class="text-[11px] uppercase tracking-wider text-white/85">Ruang Tersedia</p>
                    <p class="text-2xl font-extrabold text-white mt-1">18</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <div class="relative bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-indigo-100 hover:shadow-md transition-shadow overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-indigo-100/60"></div>
            <div class="relative flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 rounded-full px-2 py-1">+2 Bulan Ini</span>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Ruangan</h3>
            <p class="text-3xl font-extrabold text-indigo-900 mb-1">42</p>
            <p class="text-xs text-gray-500">Semua ruangan terdaftar</p>
        </div>

        <div class="relative bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-orange-100 hover:shadow-md transition-shadow overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-orange-100/60"></div>
            <div class="relative flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-orange-700 bg-orange-50 border border-orange-100 rounded-full px-2 py-1">Live</span>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jadwal Aktif</h3>
            <p class="text-3xl font-extrabold text-indigo-900 mb-1">1,248</p>
            <p class="text-xs text-gray-500">Semester aktif saat ini</p>
        </div>

        <div class="relative bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-red-100 hover:shadow-md transition-shadow overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-red-100/60"></div>
            <div class="relative flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-red-700 bg-red-50 border border-red-100 rounded-full px-2 py-1">Perlu Tindakan</span>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Peringatan Konflik</h3>
            <p class="text-3xl font-extrabold text-indigo-900 mb-1">3</p>
            <p class="text-xs text-gray-500">Konflik jadwal belum selesai</p>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-5 sm:p-6 shadow-sm text-white">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-semibold text-indigo-200 uppercase tracking-wider mb-2">Tambah Cepat</h3>
            <p class="text-sm text-white/90 mb-4">Buat entri jadwal baru secara manual.</p>
            <button class="w-full bg-white/18 hover:bg-white/25 backdrop-blur-sm text-white font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2 transition-colors text-sm border border-white/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Jadwal Baru
            </button>
        </div>

    </div>

    {{-- Room Availability & Schedule Table --}}
    <div class="bg-white rounded-3xl shadow-sm border border-indigo-100/70 overflow-hidden">
        
        {{-- Table Header --}}
        <div class="p-5 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Ketersediaan Ruang dan Jadwal</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Kelola jadwal kelas harian dan konflik ruangan.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-900 rounded-xl hover:bg-indigo-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Ekspor
                    </button>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="mt-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari ruangan atau jadwal..." 
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>
            </div>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Ruangan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas Saat Ini</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam Kuliah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dosen</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Row 1: Occupied --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">#RT01</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">RT-01</p>
                                <p class="text-xs text-gray-500">Gedung A, Lantai 2</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">Web Programming</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                07:00 - 10:30
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-indigo-600">BS</span>
                                </div>
                                <span class="text-sm text-gray-700">Budi Santoso</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Terpakai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2: Available --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">#RT02</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">RT-02</p>
                                <p class="text-xs text-gray-500">Gedung A, Lantai 2</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-400">-</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                -
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-400">-</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Tersedia
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Row 3: Conflict --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">#RT05</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">RT-05</p>
                                <p class="text-xs text-gray-500">Gedung B, Lantai 1</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">Data Structures</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                09:00 - 12:00
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-purple-600">SR</span>
                                </div>
                                <span class="text-sm text-gray-700">Sari Rahayu</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-100">
                                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                                Konflik
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button class="px-3 py-1.5 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                                    Selesaikan
                                </button>
                                <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4: Occupied --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">#LPR01</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">LPR-01</p>
                                <p class="text-xs text-gray-500">Lab Pemrograman 1</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">Pengembangan Mobile</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                13:00 - 16:00
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-teal-100 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-teal-600">AH</span>
                                </div>
                                <span class="text-sm text-gray-700">Ahmad Husain</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Terpakai
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>

                    {{-- Row 5: Available --}}
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-500">#LPR02</span>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">LPR-02</p>
                                <p class="text-xs text-gray-500">Lab Pemrograman 2</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-400">-</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1.5 text-sm text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                -
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-400">-</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Tersedia
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Table Footer / Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Menampilkan <span class="font-semibold text-gray-900">1-5</span> dari <span class="font-semibold text-gray-900">42</span> data
                </p>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-900 hover:bg-indigo-800 rounded-lg transition-colors">1</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">2</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">3</button>
                    <button class="p-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

    </div>

@endsection
