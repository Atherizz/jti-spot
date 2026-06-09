<?php

namespace App\Services;

use App\Models\RoomClaim;
use App\Models\ScheduleCancellation;
use Carbon\Carbon;

class WhatsAppMessageFactory
{
    public function opportunityAlert(
        ScheduleCancellation $cancellation,
        bool $hasScheduleConflict,
        ?string $conflictCourseName = null
    ): string {
        $schedule = $cancellation->schedule;
        $room = $schedule?->room;
        $date = Carbon::parse($cancellation->cancellation_date)->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $time = Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . Carbon::parse($schedule->end_time)->format('H:i');
        $status = $hasScheduleConflict
            ? "Bentrok jadwal: {$conflictCourseName}. Jika jadwal asli memang kosong, batalkan dulu sebelum reservasi."
            : 'Bebas bentrok dengan jadwal kelas Anda.';

        return trim(
            "JTISpot - Peluang Ruang Kosong\n\n" .
            "Ruang: " . ($room?->name ?? '-') . "\n" .
            "Tanggal: {$date}\n" .
            "Waktu: {$time}\n" .
            "Slot dari pembatalan: " . ($schedule?->course_name ?? 'Kelas') . "\n" .
            "Status: {$status}\n\n" .
            "Reservasi: " . route('student.action.reservasi')
        );
    }

    public function reservationReminder(RoomClaim $claim): string
    {
        $date = Carbon::parse($claim->claim_date)->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $time = Carbon::parse($claim->start_time)->format('H:i') . ' - ' . Carbon::parse($claim->end_time)->format('H:i');
        $quorumSize = (int) env('QUORUM_SIZE', 5);

        return trim(
            "JTISpot - Reminder Reservasi\n\n" .
            "Ruang: " . ($claim->room?->name ?? '-') . "\n" .
            "Tanggal: {$date}\n" .
            "Waktu: {$time}\n" .
            "Kelas: " . ($claim->claimerGroup?->name ?? '-') . "\n\n" .
            "Pastikan minimal {$quorumSize} mahasiswa siap scan QR saat sesi dimulai agar kuorum tercapai."
        );
    }

    public function quorumCritical(RoomClaim $claim, int $currentQuorum, int $quorumSize): string
    {
        $deadline = Carbon::parse($claim->start_time)->addMinutes(15)->format('H:i');

        return trim(
            "JTISpot - Kuorum Belum Cukup\n\n" .
            "Ruang: " . ($claim->room?->name ?? '-') . "\n" .
            "Kelas: " . ($claim->claimerGroup?->name ?? '-') . "\n" .
            "Scan saat ini: {$currentQuorum}/{$quorumSize}\n" .
            "Batas kuorum: {$deadline}\n\n" .
            "Segera koordinasikan anggota kelas untuk scan QR agar reservasi tidak otomatis gagal."
        );
    }
}
