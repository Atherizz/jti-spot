<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomImportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomActionController;
use App\Models\Room;
use Carbon\Carbon;

Route::get('/', function () {
    $now = Carbon::now();
    $dayOfWeek = $now->dayOfWeek;
    $currentTime = $now->format('H:i:s');

    $rooms = Room::with(['schedules.classGroup'])
        ->when(request('floor'), function ($query, $floor) {
            return $query->where('floor', $floor);
        })
        ->get()
        ->map(function ($room) use ($dayOfWeek, $currentTime) {
            $currentSchedule = $room->schedules->first(function ($schedule) use ($dayOfWeek, $currentTime) {
                return $schedule->day_of_week == $dayOfWeek
                    && $schedule->start_time <= $currentTime
                    && $schedule->end_time >= $currentTime;
            });

            $room->current_schedule = $currentSchedule;
            $room->display_group = $currentSchedule ? $currentSchedule->classGroup->name : null;
            $room->room_type = str_contains(strtoupper($room->name), 'STUDIO') ? 'AULA' : (str_contains(strtoupper($room->name), 'LAB') || str_contains(strtoupper($room->room_code), 'L') ? 'LAB' : 'KELAS');

            return $room;
        });

    $stats = [
        'available' => $rooms->where('current_status', 'available')->count(),
        'occupied' => $rooms->where('current_status', 'occupied')->count(),
        'soon' => $rooms->filter(function ($room) use ($now) {
            if (! $room->current_schedule) {
                return false;
            }
            $end = Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
            $diffMinutes = $end->diffInMinutes($now, false);
            return $diffMinutes > 0 && $diffMinutes <= 15;
        })->count(),
        'labUsage' => $rooms->count() ? round($rooms->where('room_type', 'LAB')->where('current_status', 'occupied')->count() / max($rooms->where('room_type', 'LAB')->count(), 1) * 100) : 0,
    ];

    return view('guest', compact('rooms', 'stats'));
});

Route::get('/peta-ruang', function () {
    $now = Carbon::now();
    $dayOfWeek = $now->dayOfWeek;
    $currentTime = $now->format('H:i:s');

    // Menerapkan filter lantai jika ada parameter 'floor' di URL
    $rooms = Room::with(['schedules.classGroup'])
        ->when(request('floor'), function ($query, $floor) {
            return $query->where('floor', $floor);
        })
        ->get()
        ->map(function ($room) use ($dayOfWeek, $currentTime) {
            $currentSchedule = $room->schedules->first(function ($schedule) use ($dayOfWeek, $currentTime) {
                return $schedule->day_of_week == $dayOfWeek
                    && $schedule->start_time <= $currentTime
                    && $schedule->end_time >= $currentTime;
            });

            $room->current_schedule = $currentSchedule;
            $room->display_group = $currentSchedule ? $currentSchedule->classGroup->name : 'Tidak Ada';
            $room->room_type = str_contains(strtoupper($room->name), 'STUDIO') ? 'AULA' : (str_contains(strtoupper($room->name), 'LAB') || str_contains(strtoupper($room->room_code), 'L') ? 'LAB' : 'KELAS');

            return $room;
        });

    $stats = [
        'available' => $rooms->where('current_status', 'available')->count(),
        'occupied' => $rooms->where('current_status', 'occupied')->count(),
        'soon' => $rooms->filter(function ($room) {
            if (! $room->current_schedule) {
                return false;
            }
            $now = \Carbon\Carbon::now();
            $end = \Carbon\Carbon::createFromFormat('H:i:s', $room->current_schedule->end_time);
            $diff = $end->diffInMinutes($now, false);
            return $diff > 0 && $diff <= 15;
        })->count(),
        'labUsage' => $rooms->count() ? round($rooms->where('room_type', 'LAB')->where('current_status', 'occupied')->count() / max($rooms->where('room_type', 'LAB')->count(), 1) * 100) : 0,
    ];

    return view('map', compact('rooms', 'stats'));
})->name('map');

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    
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

        Route::get('/rooms', function () {
            $hasFloor = Schema::hasColumn('rooms', 'floor');
            $hasRoomCode = Schema::hasColumn('rooms', 'room_code');

            $query = Room::query();

            if (request('q')) {
                $keyword = trim((string) request('q'));
                $query->where(function ($q) use ($keyword) {
                    if (Schema::hasColumn('rooms', 'room_code')) {
                        $q->where('room_code', 'like', '%' . $keyword . '%');
                    }

                    $q->orWhere('name', 'like', '%' . $keyword . '%');
                });
            }

            if ($hasFloor) {
                $query->orderBy('floor');
            }

            if ($hasRoomCode) {
                $query->orderBy('room_code');
            } else {
                $query->orderBy('id');
            }

            $rooms = $query->get();

            $stats = [
                'total' => $rooms->count(),
                'lab' => $rooms->filter(fn ($room) => str_starts_with(strtoupper((string) ($room->room_code ?? '')), 'L'))->count(),
                'theory' => $rooms->filter(fn ($room) => str_starts_with(strtoupper((string) ($room->room_code ?? '')), 'RT'))->count(),
                'waiting' => $rooms->where('current_status', 'waiting')->count(),
            ];

            return view('admin.room.room', compact('rooms', 'stats'));
        })->name('admin.room.room');

        Route::post('/rooms/import', [RoomImportController::class, 'import'])
            ->name('admin.room.import');

        Route::get('/rooms/{roomCode}', function (string $roomCode) {
            if (Schema::hasColumn('rooms', 'room_code')) {
                $room = Room::where('room_code', strtoupper($roomCode))->firstOrFail();
            } else {
                abort_unless(ctype_digit($roomCode), 404);
                $room = Room::findOrFail((int) $roomCode);
            }

            return view('admin.room.detail', compact('room'));
        })->name('admin.room.detail');
        Route::resource('users', AdminUserController::class)
            ->except(['show'])
            ->names('admin.users');
    });
    
});

Route::get('/debug-ip', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'ip_menurut_laravel' => $request->ip(),
        'ip_asli_dari_header' => $request->header('x-forwarded-for'),
        'semua_header' => $request->headers->all()
    ]);
});