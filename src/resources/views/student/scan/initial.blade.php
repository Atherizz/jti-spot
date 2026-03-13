@extends('layouts.dashboard')

@section('title', 'Konfirmasi Kehadiran')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="w-full max-w-md">
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            {{-- Room Icon --}}
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>

            {{-- Room Info --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $room->name }}</h2>
                <p class="text-gray-500 text-sm">Gedung {{ $room->building ?? 'JTI' }}</p>
            </div>

            {{-- Room Details --}}
            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">

                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ $room->current_status === 'available' ? 'bg-green-500' : 'bg-orange-500' }}"></span>
                            <span class="text-sm font-semibold text-gray-800">
                                {{ $room->current_status === 'available' ? 'Tersedia' : 'Terpakai' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Instruction --}}
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-blue-800">
                        Pastikan Anda berada di area gedung JTI atau terhubung ke WiFi kampus sebelum mengkonfirmasi kehadiran.
                    </p>
                </div>
            </div>

            {{-- Confirmation Form --}}
            <form id="confirmForm" method="POST" action="{{ route('scan.confirm', $room->qr_token) }}">
                @csrf
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <span class="text-lg">Konfirmasi Kehadiran</span>
                </button>
            </form>

            {{-- Cancel Button --}}
            <button onclick="window.history.back()" 
                    class="w-full mt-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-lg border border-gray-300 transition-colors">
                Batal
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
