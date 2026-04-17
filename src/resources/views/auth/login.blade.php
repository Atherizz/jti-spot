<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTI-Spot &mdash; Portal Otentikasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 font-sans text-ink flex items-center justify-center p-6 relative overflow-hidden">

    {{-- Abstract Ambient Background --}}
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-orange-100/50 blur-3xl"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-emerald-50/50 blur-3xl"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-[1000px] flex flex-col md:flex-row relative z-10 bg-white editorial-panel overflow-hidden shadow-2xl">
        
        <!-- Left Panel: Brand & Information -->
        <div class="w-full md:w-[45%] bg-ink relative flex flex-col justify-between p-10 md:p-12 overflow-hidden text-white border-r border-ink/5 group">
            
            <!-- Abstract decorative geometric pattern inside dark panel -->
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-orange-500/20 rounded-full blur-3xl transform translate-x-1/3 translate-y-1/3 pointer-events-none group-hover:bg-orange-500/30 transition-colors duration-700"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(79,70,229,0.4)] border border-orange-400">
                        <span class="font-display font-bold text-white text-lg tracking-wider">J</span>
                    </div>
                </div>
                
                <h1 class="font-display text-4xl font-bold tracking-tight mb-4 leading-tight">Sistem <br>Pemantauan <br>Ruangan Kelas Terpadu</h1>
                <p class="text-sm font-medium text-white/60 leading-relaxed max-w-[240px]">
                    Validasi ketersediaan ruang, manajemen batas kuorum kelas, dan optimasi jadwal operasional lingkungan kampus JTI secara seketika (*real-time*).
                </p>
            </div>
            
            <div class="relative z-10 mt-16 md:mt-0 flex items-center justify-between border-t border-white/10 pt-6">
                <div class="text-[10px] font-bold uppercase tracking-widest text-white/40">
                    Sistem Internal JTI Polinema
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Sistem Aktif</span>
                </div>
            </div>
        </div>

        <!-- Right Panel: Authentication Form -->
        <div class="w-full md:w-[55%] bg-white p-10 md:p-14 flex flex-col justify-center relative">
            <div class="max-w-[380px] w-full mx-auto">
                
                <div class="mb-10">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-ink uppercase tracking-widest transition-colors mb-4 group/back">
                        <svg class="w-3 h-3 group-hover/back:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Homepage
                    </a>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-ink mb-2">Otentikasi Identitas</h2>
                    <p class="text-sm font-medium text-gray-500">Kredensial valid diperlukan untuk mengelola atau mengakses parameter operasional.</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 flex gap-3 text-rose-700 shadow-sm">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="text-sm font-semibold">{!! session('error') !!}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 flex gap-3 text-rose-700 shadow-sm">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <div class="text-sm border-l border-rose-200 pl-3">
                            <ul class="list-disc list-inside font-medium space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Indentifikasi (NIM/NIP)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="reg_number" required placeholder="ID Akademik atau Surel" 
                                class="pl-11 block w-full bg-white border border-gray-200 text-ink text-sm rounded-xl py-3.5 focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all shadow-sm placeholder:text-gray-400" value="{{ old('reg_number') }}">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest">Kunci Keamanan</label>
                            <a href="#" tabindex="-1" class="text-[11px] font-bold text-orange-600 hover:text-orange-800 transition-colors uppercase tracking-widest">Lupa Sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" required placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" 
                                class="pl-11 block w-full bg-white border border-gray-200 text-ink text-sm font-medium tracking-widest rounded-xl py-3.5 focus:ring-2 focus:ring-orange-100 focus:border-orange-400 transition-all shadow-sm placeholder:tracking-normal placeholder:text-gray-400">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-300 text-orange-600 cursor-pointer">
                        </div>
                        <label for="remember_me" class="ml-2 text-sm font-medium text-gray-500 cursor-pointer">Pertahankan sesi selama 30 hari</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-xl shadow-sm shadow-orange-200 text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all hover:-translate-y-0.5">
                            Masuk ke Sistem
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>

                    <div class="pt-6 text-center">
                        <p class="text-[11px] font-semibold tracking-widest uppercase text-gray-400">
                            Kendala Autentikasi? <a href="#" class="text-orange-600 hover:text-orange-800 transition-colors border-b border-orange-200 hover:border-orange-400 pb-0.5">Kontak Administrator</a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
