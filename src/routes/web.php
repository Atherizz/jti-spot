<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomActionController;

Route::get('/', function () {
    return view('guest');
});

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('student')->middleware('can:student')->group(function () {
        Route::get('/dashboard', function () {
            return view('student.dashboard.home');
        })->name('student.dashboard.home');

        Route::get('/scan/{qr_token}', [RoomActionController::class, 'scanInitial'])
             ->name('scan.initial');

        Route::post('/scan/confirm/{qr_token}', [RoomActionController::class, 'confirmScan'])
             ->middleware('check.location') 
             ->name('scan.confirm');

        Route::post('/scan/claim/{qr_token}', [RoomActionController::class, 'initiateClaim'])
             ->middleware('check.location')
             ->name('scan.claim');
    });

    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard.home');
        })->name('admin.dashboard.home');
    });
    
});

Route::get('/debug-ip', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'ip_menurut_laravel' => $request->ip(),
        'ip_asli_dari_header' => $request->header('x-forwarded-for'),
        'semua_header' => $request->headers->all()
    ]);
});






