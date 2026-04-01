@extends('layouts.dashboard')

@section('title', 'Rooms Management')

@section('content')
    @php
        $statusClass = function (string $status): string {
            return match ($status) {
                'available' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                'occupied' => 'bg-rose-50 text-rose-700 border border-rose-100',
                'waiting' => 'bg-amber-50 text-amber-700 border border-amber-100',
                default => 'bg-gray-100 text-gray-700 border border-gray-200',
            };
        };

        $dotClass = function (string $status): string {
            return match ($status) {
                'available' => 'bg-emerald-500',
                'occupied' => 'bg-rose-500',
                'waiting' => 'bg-amber-500',
                default => 'bg-gray-500',
            };
        };

        $statusLabel = function (string $status): string {
            return match ($status) {
                'available' => 'Available',
                'occupied' => 'Occupied',
                'waiting' => 'Waiting',
                default => ucwords(str_replace('_', ' ', $status)),
            };
        };
    @endphp

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->has('excel_file'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
            {{ $errors->first('excel_file') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-indigo-900">Rooms Management</h1>
            <p class="text-sm text-gray-500 mt-1">
                Manage all classroom spaces, track real-time availability, and configure room properties.
            </p>
        </div>

        <button class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-900 bg-amber-400 rounded-xl hover:bg-amber-300 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Room
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M9 11h6" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Rooms</h3>
            <p class="text-3xl font-extrabold text-indigo-900">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 4h14a2 2 0 012 2v7H3V6a2 2 0 012-2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Lab Rooms</h3>
            <p class="text-3xl font-extrabold text-indigo-900">{{ $stats['lab'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M4 6h16v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Theory Rooms</h3>
            <p class="text-3xl font-extrabold text-indigo-900">{{ $stats['theory'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-12.728 12.728M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Waiting</h3>
            <p class="text-3xl font-extrabold text-indigo-900">{{ $stats['waiting'] }}</p>
        </div>

    </div>

    {{-- Rooms Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

        <div class="p-5 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-lg font-bold text-gray-900">All Rooms</h2>

                <div class="w-full sm:w-auto space-y-2">
                    <form method="POST" action="{{ route('admin.room.import') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                        @csrf
                        <input type="file" name="excel_file" accept=".xlsx,.xls,.csv"
                            class="block w-full sm:w-64 text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-colors">
                            Import Excel
                        </button>
                    </form>

                    <form method="GET" action="{{ route('admin.room.room') }}" class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="relative w-full sm:w-72">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search rooms..."
                                class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 outline-none transition placeholder:text-gray-400" />
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M6 12h12M10 20h4" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-left">
                        <th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Room ID</th>
                        <th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Floor</th>
                        <th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Live Status</th>
                        <th class="px-5 py-3 text-[11px] font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rooms as $room)
                        <tr class="hover:bg-gray-50 transition-colors text-sm text-gray-700">
                            <td class="px-5 py-4 font-semibold text-gray-900">{{ $room->room_code ?? ('ROOM-' . $room->id) }}</td>
                            <td class="px-5 py-4">{{ $room->floor ? $room->floor . 'th Floor' : '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass($room->current_status) }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass($room->current_status) }}"></span>
                                    {{ $statusLabel($room->current_status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.room.detail', ['roomCode' => $room->room_code ?? $room->id]) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-indigo-700 hover:text-indigo-900 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                    </svg>
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-sm text-gray-500">No rooms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 py-4 border-t border-gray-100 text-sm text-gray-500">
            <p>Showing {{ $rooms->count() }} room entries</p>
            <div class="flex items-center gap-5">
                <button class="text-gray-400 hover:text-gray-600 transition-colors">Previous</button>
                <button class="font-medium text-indigo-700 hover:text-indigo-900 transition-colors">Next</button>
            </div>
        </div>
    </div>

@endsection