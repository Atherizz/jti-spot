<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use App\Models\RoomClaim;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StudentActionController extends Controller
{
    /**
     * Tampilkan halaman Pusat Aksi (hub navigasi).
     */
    public function center(Request $request): View
    {
        $user = $request->user();

        // Pembatalan kelas milik kelas mahasiswa ini
        $cancellations = ScheduleCancellation::with('schedule')
            ->whereHas('schedule', function ($query) use ($user) {
                $query->where('class_group_id', $user->class_group_id);
            })
            ->get()
            ->map(fn (ScheduleCancellation $cancellation) => [
                'type'      => 'pembatalan',
                'title'     => $cancellation->schedule?->course_name ?? 'Pembatalan Kelas',
                'date'      => $cancellation->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
                'timestamp' => $cancellation->created_at,
            ]);

        // Reservasi ruangan milik kelas mahasiswa ini
        $reservations = RoomClaim::with('schedule')
            ->where('claimer_group_id', $user->class_group_id)
            ->get()
            ->map(fn (RoomClaim $claim) => [
                'type'      => 'reservasi',
                'title'     => $claim->schedule?->course_name ?? 'Reservasi Ruangan',
                'date'      => $claim->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
                'timestamp' => $claim->created_at,
            ]);

        // Gabungkan, urutkan berdasarkan waktu terbaru, ambil 5 teratas
        $recentRequests = collect($cancellations)
            ->merge($reservations)
            ->sortByDesc('timestamp')
            ->take(5)
            ->values()
            ->all();

        return view('student.actionCenter', [
            'recentRequests' => $recentRequests,
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // RESERVASI RUANGAN
    // ─────────────────────────────────────────────────────────────

    /**
     * Tampilkan form reservasi ruangan (H-1 / H-2).
     */
    public function showReservasi(Request $request): View
    {
        $user            = $request->user();
        $classGroupId    = $user->class_group_id;
        $now             = Carbon::now();

        // Ambil jadwal yang dibatalkan dalam 2 hari ke depan
        $endDate = $now->copy()->addDays(4);
        
        $cancellations = ScheduleCancellation::with(['schedule.room', 'schedule.classGroup'])
            ->whereHas('schedule', function ($query) use ($classGroupId) {
                $query->where('class_group_id', '!=', $classGroupId);
            })
            ->whereBetween('cancellation_date', [$now->toDateString(), $endDate->toDateString()])
            ->get();

        $upcomingSchedules = collect();
        
        foreach ($cancellations as $cancellation) {
            $schedule = $cancellation->schedule;
            if (!$schedule) continue;

            $targetDate = Carbon::parse($cancellation->cancellation_date);
            
            // Jika jadwal hari ini, pastikan kelas belum berakhir
            if ($targetDate->isToday()) {
                if (Carbon::parse($schedule->end_time)->format('H:i:s') <= $now->format('H:i:s')) {
                    continue; // Sudah terlewat
                }
            }

            // Pastikan belum diklaim/direservasi oleh kelas lain
            $alreadyClaimed = RoomClaim::where('schedule_id', $schedule->id)
                ->where('claim_date', $targetDate->toDateString())
                ->whereIn('status', ['pending_quorum', 'locked'])
                ->exists();

            if ($alreadyClaimed) {
                continue;
            }

            $item = clone $schedule;
            $item->class_date = $targetDate->toDateString();
            $item->reservation_data = $schedule->id . '|' . $targetDate->toDateString();
            $upcomingSchedules->push($item);
        }

        $upcomingSchedules = $upcomingSchedules->sortBy(fn($s) => $s->class_date . ' ' . $s->start_time)->values();

        $availableRooms = Room::orderBy('name')->get();

        return view('student.action.reservasi', [
            'upcomingSchedules' => $upcomingSchedules,
            'availableRooms'    => $availableRooms,
        ]);
    }

    /**
     * Simpan permohonan reservasi ruangan.
     */
    public function storeReservasi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedule_data'    => ['required', 'string'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ], [
            'schedule_data.required' => 'Silakan pilih jadwal kelas yang akan direservasi.',
        ]);

        $user = $request->user();

        $parts = explode('|', $validated['schedule_data']);
        if (count($parts) !== 2) {
            return back()->withErrors(['schedule_data' => 'Data jadwal tidak valid.'])->withInput();
        }

        $scheduleId = $parts[0];
        $reservationDateStr = $parts[1];

        $schedule = Schedule::findOrFail($scheduleId);

        // Validasi jendela waktu H s/d H+2
        $reservationDate = Carbon::parse($reservationDateStr);
        $today           = Carbon::today();
        $diffDays        = $today->diffInDays($reservationDate, false);

        if ($diffDays < 0 || $diffDays > 3) {
            return back()->withErrors([
                'schedule_data' => 'Reservasi hanya dapat diajukan untuk jadwal maksimal 2 hari ke depan.',
            ])->withInput();
        }

        // Validasi: Pastikan jadwal benar-benar berstatus dibatalkan pada tanggal tersebut
        $isCancelled = ScheduleCancellation::where('schedule_id', $schedule->id)
            ->where('cancellation_date', $reservationDateStr)
            ->exists();

        if (!$isCancelled) {
            return back()->withErrors(['schedule_data' => 'Jadwal yang dipilih tidak berstatus dibatalkan atau tidak tersedia untuk direservasi.'])->withInput();
        }

        // Validasi: Pastikan kelas ini bukan kelas yang membatalkan jadwal tersebut
        if ((int) $schedule->class_group_id === (int) $user->class_group_id) {
            return back()->withErrors(['schedule_data' => 'Anda tidak dapat mereservasi ruangan dari jadwal kelas Anda sendiri yang telah dibatalkan.'])->withInput();
        }

        // Validasi: Pastikan jadwal belum diklaim/direservasi oleh kelas lain
        $alreadyClaimed = RoomClaim::where('schedule_id', $schedule->id)
            ->where('claim_date', $reservationDateStr)
            ->whereIn('status', ['pending_quorum', 'locked'])
            ->exists();

        if ($alreadyClaimed) {
            return back()->withErrors(['schedule_data' => 'Maaf, jadwal kelas yang dibatalkan tersebut sudah lebih dulu direservasi oleh kelas lain.'])->withInput();
        }

        // Validasi: Pastikan jadwal yang direservasi tidak bertabrakan dengan jadwal asli
        $conflictingSchedules = Schedule::where('class_group_id', $user->class_group_id)
            ->where('day_of_week', $reservationDate->dayOfWeek)
            ->where(function ($query) use ($schedule) {
                // Overlap detection: (StartA < EndB) AND (EndA > StartB)
                $query->where('start_time', '<', $schedule->end_time)
                      ->where('end_time', '>', $schedule->start_time);
            })
            ->pluck('id')
            ->toArray();

        if (!empty($conflictingSchedules)) {
            // Cek apakah jadwal yang bentrok sudah dibatalkan di tanggal reservasi
            $cancelledScheduleIds = ScheduleCancellation::whereIn('schedule_id', $conflictingSchedules)
                ->where('cancellation_date', $reservationDateStr)
                ->pluck('schedule_id')
                ->toArray();

            // Filter: jadwal yang bentrok TAPI BELUM dibatalkan
            $activeConflicts = array_diff($conflictingSchedules, $cancelledScheduleIds);

            if (!empty($activeConflicts)) {
                $conflictSchedule = Schedule::find($activeConflicts[0]);

                return back()->withErrors([
                    'schedule_data' => "Kelas Anda memiliki jadwal asli yang bentrok: {$conflictSchedule->course_name} (" . substr($conflictSchedule->start_time, 0, 5) . " - " . substr($conflictSchedule->end_time, 0, 5) . "). Batalkan jadwal tersebut terlebih dahulu jika ingin reservasi slot ini."
                ])->withInput();
            }
        }

        // Simpan ke tabel room_claims (mereservasi ruangan dari jadwal kelas lain yang batal)
        $claimData = [
            'room_id'          => $schedule->room_id,
            'schedule_id'      => $schedule->id,
            'claimer_group_id' => $user->class_group_id,
            'claim_date'       => $reservationDateStr,
            'status'           => 'pending_quorum',
        ];

        if (Schema::hasColumn('room_claims', 'claimed_by_user_id')) {
            $claimData['claimed_by_user_id'] = $user->id;
        }

        if (Schema::hasColumn('room_claims', 'start_time')) {
            $claimData['start_time'] = $schedule->start_time;
        }

        if (Schema::hasColumn('room_claims', 'end_time')) {
            $claimData['end_time'] = $schedule->end_time;
        }

        RoomClaim::query()->create($claimData);

        return redirect()
            ->route('student.action.center')
            ->with('success', 'Reservasi ruangan berhasil! Ruangan telah dikunci untuk kelas Anda pada jadwal tersebut.');
    }

    // ─────────────────────────────────────────────────────────────
    // PEMBATALAN KELAS
    // ─────────────────────────────────────────────────────────────

    /**
     * Tampilkan form pembatalan kelas.
     */
    public function showPembatalan(Request $request): View
    {
        $user         = $request->user();
        $classGroupId = $user->class_group_id;
        $now          = Carbon::now();

        // Ambil semua jadwal milik kelas ini
        $schedules = Schedule::with('room')
            ->where('class_group_id', $classGroupId)
            ->get();

        $cancelableSchedules = collect();

        foreach ($schedules as $schedule) {
            // Cari tanggal terdekat untuk day_of_week jadwal ini
            $nextDate = $now->copy()->next($schedule->day_of_week);
            
            // Jika hari ini kebetulan sama dengan day_of_week, cek apakah jadwal masih > 24 jam ke depan
            if ($now->dayOfWeek == $schedule->day_of_week) {
                $classDateTime = Carbon::parse($now->toDateString() . ' ' . $schedule->start_time);
                if ($classDateTime->diffInHours($now) >= 24) {
                    $nextDate = $now->copy();
                } else {
                    $nextDate = $now->copy()->addWeek();
                }
            }

            // Simpan attribute virtual class_date
            $item = clone $schedule;
            $item->class_date = $nextDate->toDateString();
            
            // Generate unique identifier gabungan ID dan Tanggal agar form tau tanggal berapa yang dibatalkan
            $item->cancel_id = $schedule->id . '|' . $nextDate->toDateString();
            $cancelableSchedules->push($item);
        }

        $cancelableSchedules = $cancelableSchedules->sortBy(fn($s) => $s->class_date . ' ' . $s->start_time)->values();

        return view('student.action.pembatalan', [
            'cancelableSchedules' => $cancelableSchedules,
        ]);
    }

    /**
     * Simpan permohonan pembatalan kelas.
     */
    public function storePembatalan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'schedule_data'        => ['required', 'string'], // Format: "ID|TANGGAL"
            'cancellation_type'    => ['required', 'string', 'in:sakit,kegiatan_kampus,musibah,lainnya'],
            'reason'               => ['required', 'string', 'min:20', 'max:2000'],
            'confirm_cancellation' => ['required', 'accepted'],
        ], [
            'schedule_data.required'        => 'Silakan pilih jadwal yang akan dibatalkan.',
            'reason.min'                    => 'Justifikasi harus diisi minimal 20 karakter.',
            'confirm_cancellation.accepted' => 'Anda harus mencentang pernyataan konfirmasi sebelum mengirim.',
        ]);

        $user = $request->user();
        
        // Parse ID dan Tanggal
        $parts = explode('|', $validated['schedule_data']);
        if (count($parts) !== 2) {
            return back()->withErrors(['schedule_data' => 'Data jadwal tidak valid.'])->withInput();
        }
        
        $scheduleId = $parts[0];
        $cancellationDate = $parts[1];

        $schedule = Schedule::findOrFail($scheduleId);

        // Guard: jadwal harus milik kelas mahasiswa ini
        if ((int) $schedule->class_group_id !== (int) $user->class_group_id) {
            return back()
                ->withErrors(['schedule_id' => 'Jadwal yang dipilih tidak terdaftar untuk kelas Anda.'])
                ->withInput();
        }

        // Guard: cegah duplikasi pengajuan untuk jadwal yang sama pada tanggal tersebut
        $alreadyRequested = ScheduleCancellation::where('schedule_id', $schedule->id)
            ->where('cancellation_date', $cancellationDate)
            ->exists();

        if ($alreadyRequested) {
            return back()
                ->withErrors(['schedule_data' => 'Jadwal pada tanggal tersebut sudah dibatalkan oleh perwakilan kelas Anda.'])
                ->withInput();
        }

        ScheduleCancellation::query()->create([
            'schedule_id'       => $schedule->id,
            'cancelled_by'      => $user->id,
            'cancellation_date' => $cancellationDate,
            'cancellation_type' => $validated['cancellation_type'],
            'reason'            => $validated['reason'],
            'created_at'        => now(),
        ]);

        return redirect()
            ->route('student.action.center')
            ->with('success', 'Pembatalan kelas berhasil. Jadwal telah dibatalkan di sistem.');
    }

    /**
     * Tampilkan seluruh riwayat pengajuan mahasiswa.
     */
    public function history(Request $request): View
    {
        $user = $request->user();

        // Ambil semua pembatalan milik kelas mahasiswa ini
        $cancellations = ScheduleCancellation::query()->with(['schedule', 'cancelledBy'])
            ->whereHas('schedule', function ($query) use ($user) {
                $query->where('class_group_id', $user->class_group_id);
            })
            ->get()
            ->map(fn (ScheduleCancellation $cancellation) => [
                'type'   => 'Pembatalan Kelas',
                'title'  => $cancellation->schedule?->course_name ?? 'Pembatalan',
                'date'   => $cancellation->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
                'target' => Carbon::parse($cancellation->cancellation_date)->locale('id')->isoFormat('l, d M Y'),
                'reason' => $cancellation->reason,
                'by'     => $cancellation->cancelledBy?->name ?? 'Mahasiswa',
                'timestamp' => $cancellation->created_at,
            ]);

        // Ambil semua reservasi ruangan milik kelas mahasiswa ini
        $reservations = RoomClaim::query()->with(['schedule', 'claimedByUser', 'room'])
            ->where('claimer_group_id', $user->class_group_id)
            ->get()
            ->map(fn (RoomClaim $claim) => [
                'type'   => 'Reservasi Ruangan',
                'title'  => ($claim->schedule?->course_name ?? 'Reservasi') . ' - ' . ($claim->room?->name ?? 'Ruangan Indefinit'),
                'date'   => $claim->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
                'target' => Carbon::parse($claim->claim_date)->locale('id')->isoFormat('l, d M Y') . ' (' . Carbon::parse($claim->start_time)->format('H:i') . ' - ' . Carbon::parse($claim->end_time)->format('H:i') . ')',
                'reason' => 'Status: ' . ucwords(str_replace('_', ' ', $claim->status)),
                'by'     => $claim->claimedByUser?->name ?? 'Mahasiswa',
                'timestamp' => $claim->created_at,
            ]);

        // Gabungkan semuanya dan urutkan berdasarkan waktu terbaru
        $allRequests = collect($cancellations)
            ->merge($reservations)
            ->sortByDesc('timestamp')
            ->values();

        return view('student.action.history', [
            'allRequests' => $allRequests,
        ]);
    }
}
