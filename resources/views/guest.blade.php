@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <h1 class="text-2xl font-bold text-indigo-900">Live Status Ruang</h1>
        </div>
        <span class="text-sm text-gray-500">Diperbarui 1 menit lalu</span>
    </div>

    <!-- Stat Cards Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Available Card -->
        <div class="bg-emerald-500 rounded-xl p-6 text-white shadow-sm relative overflow-hidden">
            <div class="flex justify-between items-start">
                <h3 class="text-emerald-50 text-sm font-medium mb-1">Tersedia Sekarang</h3>
                <svg class="w-5 h-5 text-emerald-200 opacity-80" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/></svg>
            </div>
            <div class="text-4xl font-bold mb-4">12</div>
            <div class="text-emerald-100 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                +2 dari jam lalu
            </div>
        </div>
        
        <!-- Occupied Card -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Ruang Terpakai</h3>
                <div class="bg-gray-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">45</div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-rose-500 h-1.5 rounded-full" style="width: 70%"></div>
            </div>
        </div>

        <!-- Free in < 15m -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Kosong &lt; 15m</h3>
                <div class="bg-orange-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">8</div>
            <div class="text-gray-400 text-sm">
                Sebagian di Lantai 6
            </div>
        </div>
        
        <!-- Lab Usage -->
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-gray-500 text-sm font-medium">Penggunaan Lab</h3>
                <div class="bg-rose-50 p-1.5 rounded-lg">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-indigo-900 mb-4">92%</div>
            <div class="text-rose-500 text-sm">
                Permintaan tinggi saat ini
            </div>
        </div>
    </div>
    
    <!-- Filter Bar -->
    <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
        <div class="flex flex-wrap gap-2 items-center">
            <button class="bg-white border border-gray-200 px-4 py-2 rounded-md text-sm font-medium text-gray-700 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                Semua Lantai
            </button>
            <div class="bg-white border border-gray-200 rounded-md flex overflow-hidden">
                <button class="bg-indigo-900 text-white px-4 py-2 text-sm font-medium">Semua</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Kelas</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Lab</button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Aula</button>
            </div>
        </div>
        
        <div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" placeholder="Cari ruang (mis. LSI-1)" class="pl-10 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:ring-orange-500 focus:border-orange-500 w-full sm:w-64 shadow-sm">
            </div>
        </div>
    </div>
    
    <!-- Room Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Room Item -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <h3 class="text-xl font-bold text-indigo-900">LSI-1</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Tersedia
                </span>
            </div>
            <div class="text-xs text-gray-400 mb-4">LAB &bull; LANTAI 6</div>
            
            <div class="flex items-center gap-2 mb-3 text-sm text-gray-700">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Bebas hingga 13:00
            </div>
            <div class="flex items-center gap-2 mb-6 text-sm text-gray-700">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                40 Kursi
            </div>
            
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                <span class="text-xs text-emerald-600 font-medium flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Kosong Sekarang
                </span>
                <a href="#" class="text-xs text-gray-500 hover:text-indigo-600 hover:underline">Detail &rarr;</a>
            </div>
        </div>

        <!-- Occupied Room -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <h3 class="text-xl font-bold text-indigo-900">RT-02</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Terpakai
                </span>
            </div>
            <div class="text-xs text-gray-400 mb-4">TEORI &bull; LANTAI 5</div>
            
            <div class="flex items-start gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422M12 20.5l9-5-9-5-9 5 9 5z"/></svg>
                <div>
                    <div class="text-sm font-medium text-gray-900">Mobile Programming</div>
                    <div class="text-xs text-gray-500">Pak Hendra</div>
                </div>
            </div>
            
            <div class="mt-auto">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-500">Berakhir dalam</span>
                    <span class="text-gray-900 font-medium">45 mnt</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1">
                    <div class="bg-red-500 h-1 rounded-full" style="width: 45%"></div>
                </div>
            </div>
        </div>
        
        <!-- Soon Room -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <h3 class="text-xl font-bold text-indigo-900">LPR-4</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-50 text-orange-700 border border-orange-100">
                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-1.5"></span> Segera
                </span>
            </div>
            <div class="text-xs text-gray-400 mb-4">LAB &bull; LANTAI 7</div>
            
            <div class="flex items-start gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422M12 20.5l9-5-9-5-9 5 9 5z"/></svg>
                <div>
                    <div class="text-sm font-medium text-gray-900">Database Systems</div>
                    <div class="text-xs text-gray-500">Bu Ani</div>
                </div>
            </div>
            
            <div class="mt-auto">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-500">Berakhir dalam</span>
                    <span class="text-gray-900 font-medium">5 mnt</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1">
                    <div class="bg-orange-500 h-1 rounded-full" style="width: 90%"></div>
                </div>
            </div>
        </div>
        
        <!-- Occupied Room 2 -->
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm flex flex-col">
            <div class="flex justify-between items-start mb-1">
                <h3 class="text-xl font-bold text-indigo-900">AUD-1</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Terpakai
                </span>
            </div>
            <div class="text-xs text-gray-400 mb-4">AULA &bull; LANTAI 8</div>
            
            <div class="flex items-start gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <div>
                    <div class="text-sm font-medium text-gray-900">Kuliah Umum</div>
                    <div class="text-xs text-gray-500">Pembicara Tamu</div>
                </div>
            </div>
            
            <div class="mt-auto">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-500">Berakhir dalam</span>
                    <span class="text-gray-900 font-medium">1j 20m</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1">
                    <div class="bg-red-500 h-1 rounded-full" style="width: 25%"></div>
                </div>
            </div>
        </div>
    </div>
@endsection