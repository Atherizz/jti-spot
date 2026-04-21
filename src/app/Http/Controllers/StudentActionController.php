<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Schedule;
use App\Models\ScheduleCancellation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentActionController extends Controller
{
    /**
     * Tampilkan halaman Pusat Aksi (hub navigasi).
     */
    public function center(Request $request): View
    {
        $user = $request->user();

        // 5 pengajuan pembatalan terbaru milik kelas mahasiswa ini
        $recentCancellations = ScheduleCancellation::with('schedule')
            ->whereHas('schedule', function ($query) use ($user) {
                $query->where('class_group_id', $user->class_group_id);
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn (ScheduleCancellation $cancellation) => [
                'type'   => 'pembatalan',
                'title'  => $cancellation->schedule?->course_name ?? 'Pembatalan Kelas',
                'date'   => $cancellation->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
            ])
            ->all();

        return view('student.actionCenter', [
            'recentRequests' => $recentCancellations,
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

        // Jadwal mendatang milik kelas ini
        $schedules = Schedule::with('room')
            ->where('class_group_id', $classGroupId)
            ->get();

        $upcomingSchedules = collect();
        
        foreach ($schedules as $schedule) {
            // H+1
            $h1Date = $now->copy()->addDay();
            if ($h1Date->dayOfWeek == $schedule->day_of_week) {
                $item = clone $schedule;
                $item->class_date = $h1Date->toDateString();
                $upcomingSchedules->push($item);
            }
            // H+2
            $h2Date = $now->copy()->addDays(2);
            if ($h2Date->dayOfWeek == $schedule->day_of_week) {
                $item = clone $schedule;
                $item->class_date = $h2Date->toDateString();
                $upcomingSchedules->push($item);
            }
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
            'schedule_id'      => ['required', 'integer', 'exists:schedules,id'],
            'room_id'          => ['required', 'integer', 'exists:rooms,id'],
            'reservation_date' => ['required', 'date', 'after_or_equal:today'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ]);

        $user     = $request->user();
        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Validasi: jadwal harus milik kelas mahasiswa ini
        if ((int) $schedule->class_group_id !== (int) $user->class_group_id) {
            return back()->withErrors(['schedule_id' => 'Jadwal yang dipilih tidak terdaftar untuk kelas Anda.'])->withInput();
        }

        // Validasi jendela waktu H-1 / H-2
        $reservationDate = Carbon::parse($validated['reservation_date']);
        $today           = Carbon::today();
        $diffDays        = $today->diffInDays($reservationDate, false);

        if ($diffDays < 1 || $diffDays > 2) {
            return back()->withErrors([
                'reservation_date' => 'Reservasi hanya dapat diajukan untuk jadwal 1–2 hari ke depan (H-1 atau H-2).',
            ])->withInput();
        }

        // TODO: Simpan ke tabel `room_reservations` setelah migration dibuat.
        // Contoh:
        // RoomReservation::create([
        //     'user_id'          => $user->id,
        //     'schedule_id'      => $validated['schedule_id'],
        //     'room_id'          => $validated['room_id'],
        //     'reservation_date' => $validated['reservation_date'],
        //     'notes'            => $validated['notes'],
        //     'status'           => 'pending',
        // ]);

        return redirect()
            ->route('student.action.center')
            ->with('success', 'Permohonan reservasi ruangan berhasil dikirim dan sedang menunggu verifikasi.');
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

        ScheduleCancellation::create([
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
        $cancellations = ScheduleCancellation::with(['schedule', 'cancelledBy'])
            ->whereHas('schedule', function ($query) use ($user) {
                $query->where('class_group_id', $user->class_group_id);
            })
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (ScheduleCancellation $cancellation) => [
                'type'   => 'Pembatalan Kelas',
                'title'  => $cancellation->schedule?->course_name ?? 'Pembatalan',
                'date'   => $cancellation->created_at?->locale('id')->isoFormat('D MMMM YYYY, HH:mm') ?? '-',
                'target' => Carbon::parse($cancellation->cancellation_date)->locale('id')->isoFormat('l, d M Y'),
                'reason' => $cancellation->reason,
                'by'     => $cancellation->cancelledBy?->name ?? 'Mahasiswa',
            ]);

        // Gabungkan semuanya (nanti bisa ditambah dengan reservasi jika sudah ada tabelnya)
        $allRequests = collect($cancellations);

        return view('student.action.history', [
            'allRequests' => $allRequests,
        ]);
    }
}
