<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTISpot - Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[550px]">
        
        <!-- Sisi Kiri (Bagian Gelap) -->
        <div class="w-full md:w-1/2 bg-[#1e2333] text-white p-10 flex flex-col justify-between items-center text-center relative">
            <!-- Dekorasi gradient -->
            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-[#2c1d2e]/30 to-transparent"></div>
            
            <div class="flex-1 flex flex-col justify-center items-center z-10 w-full relative">
                <div class="relative mb-6">
                    <div class="absolute inset-0 bg-white/10 rounded-full scale-110 animate-pulse"></div>
                    
                    <div class="relative bg-white rounded-full p-4 shadow-2xl ring-4 ring-white/20">
                        <img src="/images/logo1.png" alt="JTISpot Logo" class="w-24 h-24 rounded-full object-contain">
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold mb-4">JTISpot</h1>
                <p class="text-gray-300 text-sm max-w-xs leading-relaxed">
                    Cek ketersediaan ruang secara real-time. Dikelola oleh komunitas JTI Polinema.
                </p>
            </div>
            
            <div class="z-10 text-xs text-gray-500 mt-auto pt-8">
                &copy; {{ date('Y') }} JTI Polinema
            </div>
        </div>

        <!-- Sisi Kanan (Form Login) -->
        <div class="w-full md:w-1/2 p-10 lg:p-12 flex flex-col justify-center bg-white">
            <div class="max-w-md w-full mx-auto">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke halaman utama
                </a>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat datang kembali</h2>
                <p class="text-sm text-gray-500 mb-8">Silakan masukkan detail Anda untuk masuk.</p>

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline whitespace-pre-wrap">{!! session('error') !!}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIM / NIP / Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="reg_number" required placeholder="Masukkan ID atau Email Anda" class="pl-10 block w-full border border-gray-200 rounded-lg py-2.5 bg-gray-50 text-sm text-gray-900 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-colors" value="{{ old('reg_number') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" required placeholder="••••••••" class="pl-10 block w-full border border-gray-200 rounded-lg py-2.5 bg-gray-50 text-sm text-gray-900 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-colors">
                            <!-- Toggle switch if needed could be put here -->
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                                Ingat saya selama 30 hari
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-orange-600 hover:text-orange-500">Lupa kata sandi?</a>
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#e05a33] hover:bg-[#d04b28] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors mt-6">
                        Masuk
                    </button>
                    
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>