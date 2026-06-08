<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomImportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomActionController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentScheduleController;
use App\Http\Controllers\StudentActionController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminClassGroupController;
use App\Models\Room;
use Carbon\Carbon;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\RoomQrPdfController;
use App\Http\Controllers\ClassRepTokenController;

Route::get('/debug/ip', [DebugController::class, 'showIpForm'])->name('debug.ip');
Route::post('/debug/ip', [DebugController::class, 'inspectIp'])->name('debug.ip.check');

Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/live-data', [GuestController::class, 'liveData'])->name('live.data');
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

        Route::get('/action/history', [StudentActionController::class, 'history'])
            ->name('student.action.history');

        // ── Pusat Aksi (Hanya Ketua Kelas) ──────────────────────────
        Route::middleware('can:class_rep')->group(function () {
            Route::post('/session/end', [StudentDashboardController::class, 'endSession'])
                ->name('student.session.end');
            Route::post('/session/extend-quorum', [StudentDashboardController::class, 'extendQuorum'])
                ->name('student.session.extend-quorum');
            Route::get('/action', [StudentActionController::class, 'center'])
                ->name('student.action.center');

            Route::get('/action/reservasi', [StudentActionController::class, 'showReservasi'])
                ->name('student.action.reservasi');
            Route::post('/action/reservasi', [StudentActionController::class, 'storeReservasi'])
                ->name('student.action.reservasi.store');

            Route::get('/action/pembatalan', [StudentActionController::class, 'showPembatalan'])
                ->name('student.action.pembatalan');
            Route::post('/action/pembatalan', [StudentActionController::class, 'storePembatalan'])
                ->name('student.action.pembatalan.store');
        });
        Route::post('/claim-class-rep-token', [ClassRepTokenController::class, 'claim'])
            ->name('student.claim.class-rep-token');
    });

    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::get('/dashboard', [AdminScheduleController::class, 'dashboard'])->name('admin.dashboard.home');
        
        Route::get('/rooms', [AdminRoomController::class, 'index'])->name('admin.room.room');
        Route::get('/rooms/qr-print-all', [RoomQrPdfController::class, 'printAll'])->name('admin.rooms.qr.print.all');
        Route::get('/rooms/{roomCode}', [AdminRoomController::class, 'show'])->name('admin.room.detail');
        Route::get('/class-groups', [AdminClassGroupController::class, 'index'])->name('admin.class-groups.index');
        Route::post('/class-groups/{classGroup}/generate-token', [AdminClassGroupController::class, 'generateToken'])
            ->name('admin.class-groups.generate-token');
        Route::post('/majors', [AdminClassGroupController::class, 'storeProdi'])
            ->name('admin.majors.store');
        Route::put('/majors/{major}', [AdminClassGroupController::class, 'updateProdi'])
            ->name('admin.majors.update');
        Route::delete('/majors/{major}', [AdminClassGroupController::class, 'destroyProdi'])
            ->name('admin.majors.destroy');
        Route::get('/schedules', [AdminScheduleController::class, 'index'])->name('admin.schedules');
        Route::get('/schedules/template', [RoomImportController::class, 'downloadTemplate'])->name('admin.schedules.template');
        Route::post('/schedules/import', [RoomImportController::class, 'import'])->name('admin.schedules.import');

        Route::resource('users', AdminUserController::class)->except(['show'])->names('admin.users');
    });
});