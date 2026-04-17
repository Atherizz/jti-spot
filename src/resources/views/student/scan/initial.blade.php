@extends('layouts.dashboard')

@section('title', 'Konfirmasi Kehadiran')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-140px)] stagger-1">
    <div class="w-full max-w-md">
        
        <div class="editorial-panel bg-white p-8 relative overflow-hidden group">
            {{-- Abstract glow --}}
            <div class="absolute -right-8 -top-8 w-40 h-40 bg-orange-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

            {{-- Room Icon --}}
            <div class="flex justify-center mb-8 relative z-10">
                <div class="w-20 h-20 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-500">
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>

            {{-- Room Info --}}
            <div class="text-center mb-8 relative z-10">
                <h2 class="font-display text-3xl font-bold text-ink mb-2 tracking-tight">{{ $room->name }}</h2>
                <div class="flex items-center justify-center gap-2">
                    <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                    <p class="text-[11px] font-semibold uppercase tracking-widest text-ink/50">Gedung {{ $room->building ?? 'JTI' }}</p>
                    <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                </div>
            </div>

            {{-- Room Details --}}
            <div class="bg-gray-50/80 border border-gray-100 rounded-xl p-5 mb-8 relative z-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sistem Ketersediaan</span>
                    <span class="inline-flex items-center gap-2">
                        @if($room->current_status === 'available')
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Tersedia</span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-orange-700 uppercase tracking-widest">Terpakai</span>
                        @endif
                    </span>
                </div>
            </div>

            {{-- Instruction --}}
            <div class="bg-orange-50/50 border border-orange-100 rounded-xl p-5 mb-8 relative z-10 flex gap-4">
                <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs font-medium text-orange-900/80 leading-relaxed">
                    Sistem mewajibkan geo-validasi. Pastikan Anda berada di area gedung JTI atau terhubung ke WiFi lokal sebelum mengirimkan log kehadiran kelas.
                </p>
            </div>

            {{-- Confirmation Form --}}
            <form id="confirmForm" method="POST" action="{{ route('scan.confirm', $room->qr_token) }}" class="relative z-10">
                @csrf
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                
                <button type="submit" 
                        class="w-full bg-ink text-white font-semibold py-4 px-6 rounded-xl transition-all shadow-sm hover:shadow-md hover:bg-ink/90 flex items-center justify-center gap-2 group/btn">
                    Konfirmasi Kehadiran
                    <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </button>
            </form>

            {{-- Cancel Button --}}
            <button onclick="window.history.back()" 
                    class="w-full mt-4 bg-white hover:bg-gray-50 text-ink font-semibold py-3 px-6 rounded-xl border border-gray-200 transition-colors relative z-10 text-sm shadow-sm group">
                Batalkan Identifikasi
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Try to get geolocation when page loads
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lng').value = position.coords.longitude;
                console.log('Location obtained:', position.coords.latitude, position.coords.longitude);
            },
            (error) => {
                console.log('Geolocation error:', error.message);
                // Leave lat/lng empty if geolocation fails
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
</script>
@endpush

@endsection

