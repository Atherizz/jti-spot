@extends('layouts.dashboard')

@section('title', 'Room Detail')

@section('content')
    @php
        $roomLabel = $room->room_code ?? ('ROOM-' . $room->id);
        $buildingLabel = $room->floor ? ('Building ' . $room->floor) : 'Building -';
        $scanUrl = route('scan.initial', $room->qr_token);
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=10&data=' . urlencode($scanUrl);
    @endphp

    {{-- Breadcrumb --}}
    <div class="mb-4">
        <p class="text-xs sm:text-sm text-gray-500">
            Rooms <span class="mx-1">/</span> {{ $buildingLabel }} <span class="mx-1">/</span>
            <span class="font-semibold text-gray-700">{{ $roomLabel }}</span>
        </p>
    </div>

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">{{ $roomLabel }} Management & Monitoring</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage room availability, view live scan logs, and manage class booking QR codes.
            </p>
        </div>

        <button class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Room Details
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Occupancy Rate</h3>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <p class="text-3xl font-extrabold text-indigo-900">75%</p>
                <p class="text-xs text-emerald-600 font-semibold mb-1">+5%</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Scans Today</h3>
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <p class="text-3xl font-extrabold text-indigo-900">120</p>
                <p class="text-xs text-gray-400 mb-1">today</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Conflict Alerts</h3>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-7.938 4h15.876c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-end gap-2">
                <p class="text-3xl font-extrabold text-indigo-900">2</p>
                <p class="text-xs text-red-500 font-semibold mb-1">+1</p>
            </div>
        </div>
    </div>

    {{-- Detail Content --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <section class="xl:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <h2 class="text-lg font-bold text-gray-900">Static QR Code</h2>
            <p class="text-sm text-gray-500 mt-1">Scan for class booking in {{ $roomLabel }}</p>

            <div class="mt-5 rounded-2xl border border-gray-100 bg-gray-50 p-4 flex items-center justify-center">
                <div class="w-56 h-56 bg-white border border-gray-200 rounded-xl p-3 flex items-center justify-center shadow-sm">
                    <img src="{{ $qrImageUrl }}" alt="QR Booking {{ $roomLabel }}" class="w-full h-full rounded-lg object-contain" />
                </div>
            </div>

            <a href="{{ $scanUrl }}" target="_blank" rel="noopener noreferrer" class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-indigo-700 rounded-xl hover:bg-indigo-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16" />
                </svg>
                Open Booking Link
            </a>
            <p class="text-xs text-gray-400 mt-3 text-center break-all">{{ $scanUrl }}</p>
        </section>

        <section class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Live Scan Log</h2>
                    <p class="text-sm text-gray-500 mt-1">Recent student scans for this room.</p>
                </div>
                <button class="text-indigo-600 hover:text-indigo-700 transition-colors p-1" title="Refresh">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.581M5 9a7 7 0 0112.48-3.856L20 9M4 15l2.52 3.856A7 7 0 0019 15" />
                    </svg>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left">
                            <th class="px-6 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                            <th class="px-6 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Verification</th>
                            <th class="px-6 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">Budi Santoso</td>
                            <td class="px-6 py-4 text-gray-500">2141720001</td>
                            <td class="px-6 py-4">08:15 AM</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600">WiFi</span></td>
                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1 text-emerald-600 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Success</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">Siti Aminah</td>
                            <td class="px-6 py-4 text-gray-500">2141720002</td>
                            <td class="px-6 py-4">08:12 AM</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">GPS</span></td>
                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1 text-emerald-600 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Success</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">Agus Pratama</td>
                            <td class="px-6 py-4 text-gray-500">2141720003</td>
                            <td class="px-6 py-4">08:05 AM</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600">WiFi</span></td>
                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1 text-emerald-600 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Success</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">Unknown User</td>
                            <td class="px-6 py-4 text-gray-400">-</td>
                            <td class="px-6 py-4">07:59 AM</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Failed</span></td>
                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1 text-red-500 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Location Mismatch</span></td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">Dewi Lestari</td>
                            <td class="px-6 py-4 text-gray-500">2141720005</td>
                            <td class="px-6 py-4">07:55 AM</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">GPS</span></td>
                            <td class="px-6 py-4"><span class="inline-flex items-center gap-1 text-emerald-600 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Success</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100">
                <a href="#" class="text-sm font-medium text-indigo-700 hover:text-indigo-900 transition-colors">View All Logs</a>
            </div>
        </section>
    </div>
@endsection
