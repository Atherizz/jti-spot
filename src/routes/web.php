<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomImportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomActionController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentScheduleController;
use App\Models\Room;
use Carbon\Carbon;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\DebugController;

Route::get('/debug/ip', [DebugController::class, 'showIpForm'])->name('debug.ip');
Route::post('/debug/ip', [DebugController::class, 'inspectIp'])->name('debug.ip.check');

Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/peta-ruang', [GuestController::class, 'map'])->name('map');

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    
    Route::prefix('student')->middleware('can:student')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'home'])
            ->name('student.dashboard.home');

        Route::get('/activity-log', [StudentDashboardController::class, 'activityLog'])
            ->name('student.activity.log');

        Route::get('/schedules', [StudentScheduleController::class, 'index'])
            ->name('student.schedules');

        Route::post('/attendance/confirm', [RoomActionController::class, 'confirmWithoutScan'])
            ->name('student.attendance.confirm');

        Route::get('/scan/{qr_token}', [RoomActionController::class, 'scanInitial'])
             ->name('scan.initial');

           Route::get('/check-in/{qr_token}', [RoomActionController::class, 'showCheckIn'])
               ->name('student.checkin.show');

        Route::post('/scan/confirm/{qr_token}', [RoomActionController::class, 'confirmScan'])
             ->middleware('check.location') 
             ->name('scan.confirm');

        Route::post('/scan/claim/{qr_token}', [RoomActionController::class, 'initiateClaim'])
             ->middleware('check.location')
             ->name('scan.claim');
    });

    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::view('/dashboard', 'admin.dashboard.home')->name('admin.dashboard.home');
        
        Route::get('/rooms', [AdminRoomController::class, 'index'])->name('admin.room.room');
        Route::post('/rooms/import', [RoomImportController::class, 'import'])->name('admin.room.import');
        Route::get('/rooms/{roomCode}', [AdminRoomController::class, 'show'])->name('admin.room.detail');

        Route::resource('users', AdminUserController::class)->except(['show'])->names('admin.users');
    });
});