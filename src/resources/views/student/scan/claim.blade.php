@extends('layouts.dashboard')

@section('title', 'Klaim Ruangan')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Klaim Reservasi Ruangan</h1>
        <p class="text-sm text-gray-500 mt-1">
            Klaim ruangan untuk sesi kelas Anda.
        </p>
    </div>

    {{-- Alert Box --}}
    <div class="mb-6 bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex items-start gap-3 shadow-sm">
        <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 16v-4m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-blue-900">Informasi: Persyaratan Kuorum</p>
            <p class="text-sm text-blue-700 mt-0.5 leading-relaxed">Untuk proses klaim ruangan, sejumlah anggota kelas harus melakukan scan (mencapai kuorum). Pastikan kelas Anda telah menerima informasi sebelum Anda mengajukan klaim.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-gray-100">
        <form action="{{ route('scan.claim', $qrToken) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Room Selection (Disabled) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Ruangan</label>
                    <div class="relative">
                        <select class="w-full appearance-none bg-gray-100 border border-gray-200 text-gray-500 p-3 rounded-xl focus:outline-none transition-colors pointer-events-none cursor-not-allowed" disabled>
                            <option selected>{{ $room->name ?? 'Ruangan Tidak Diketahui' }}</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Original Schedule (Editable dropdown) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Kelas Anda (Pengganti)</label>
                    <div class="relative">
                        <select name="original_schedule_id" class="w-full appearance-none bg-gray-50 border border-gray-200 text-gray-700 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors">
                            <option disabled selected>Pilih jadwal kelas Anda...</option>
                            @foreach($originalSchedules as $schedule)
                                <option value="{{ $schedule->id }}">
                                    {{ $schedule->course_name }} ({{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }})
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Target Schedule (Disabled) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Target (Yang Diklaim)</label>
                    <div class="relative">
                        <select class="w-full appearance-none bg-gray-100 border border-gray-200 text-gray-500 p-3 rounded-xl focus:outline-none transition-colors pointer-events-none cursor-not-allowed" disabled>
                            @if($claimedSchedule)
                                <option selected>
                                    {{ $claimedSchedule->course_name }} ({{ \Carbon\Carbon::parse($claimedSchedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($claimedSchedule->end_time)->format('H:i') }})
                                </option>
                            @else
                                <option selected>Tidak ada jadwal saat ini pada ruangan ini</option>
                            @endif
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @if($claimedSchedule)
                        <input type="hidden" name="claimed_schedule_id" value="{{ $claimedSchedule->id }}">
                    @endif
                </div>

                {{-- Claim Date (Disabled) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Klaim</label>
                    <div class="relative">
                        <input type="date" value="{{ $claimedDate }}" readonly class="w-full appearance-none bg-gray-100 border border-gray-200 text-gray-500 p-3 rounded-xl focus:outline-none transition-colors pointer-events-none cursor-not-allowed [&::-webkit-calendar-picker-indicator]:opacity-50">
                    </div>
                </div>
            </div>

            {{-- Reason for Claim (Editable) --}}
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Klaim (Opsional)</label>
                <textarea name="reason" rows="3" placeholder="Sertakan konteks tambahan mengapa ruangan ini di-klaim..." class="w-full bg-gray-50 border border-gray-200 text-gray-700 p-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-colors resize-none placeholder-gray-400"></textarea>
            </div>

            {{-- Buttons --}}
            <div class="mt-8 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('student.dashboard.home') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200 bg-white text-center">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-orange-500 text-white font-semibold hover:bg-orange-600 shadow-sm flex items-center justify-center gap-2 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Ajukan Klaim
                </button>
            </div>
        </form>
    </div>

@endsection