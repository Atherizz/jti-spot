<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DashboardMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('activity_logs')) {
            $this->command?->warn('DashboardMahasiswaSeeder: tabel activity_logs belum ada. Jalankan migration terlebih dahulu.');
            return;
        }

        $fikar = DB::table('users')->where('email', 'Fikarbahrul99@gmail.com')->first();
        $classGroupId = $fikar->class_group_id ?? DB::table('users')->whereNotNull('class_group_id')->value('class_group_id');

        if (!$classGroupId) {
            $this->command?->warn('DashboardMahasiswaSeeder: tidak ada class_group_id yang bisa dipakai.');
            return;
        }

        $dimas = DB::table('users')->where('email', 'dimas@example.com')->first();
        if (!$dimas) {
            DB::table('users')->insert([
                'name' => 'Dimas',
                'email' => 'dimas@example.com',
                'reg_number' => '2441070999',
                'role' => 'student',
                'class_group_id' => $classGroupId,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $dimas = DB::table('users')->where('email', 'dimas@example.com')->first();
        }

        $student = $dimas;
        $classRep = DB::table('users')->where('role', 'class_rep')->whereNotNull('class_group_id')->first();

        if (!$student && !$classRep) {
            $student = DB::table('users')->whereNotNull('class_group_id')->first();
        }

        if (!$student && !$classRep) {
            $this->command?->warn('DashboardMahasiswaSeeder: tidak ada user dengan class_group_id.');
            return;
        }

        $classGroupId = $student->class_group_id ?? $classRep->class_group_id;

        $schedule = DB::table('schedules')
            ->where('class_group_id', $classGroupId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->first();

        $room = $schedule
            ? DB::table('rooms')->where('id', $schedule->room_id)->first()
            : DB::table('rooms')->first();

        if (!$room) {
            $this->command?->warn('DashboardMahasiswaSeeder: tidak ada data ruangan.');
            return;
        }

        $courseName = $schedule->course_name ?? 'Sesi Validasi Kehadiran';
        $roomName = $room->name ?? 'Ruangan';
        $now = Carbon::now();

        DB::table('activity_logs')->insert([
            [
                'user_id' => $student->id ?? null,
                'room_id' => $room->id ?? null,
                'schedule_id' => $schedule->id ?? null,
                'room_claim_id' => null,
                'class_group_id' => $classGroupId,
                'event_type' => 'SCAN_SUCCESS',
                'metadata' => json_encode([
                    'user_name' => $student->name ?? 'Mahasiswa',
                    'room_name' => $roomName,
                    'subject_name' => $courseName,
                ]),
                'created_at' => $now->copy()->subMinutes(2),
                'updated_at' => $now->copy()->subMinutes(2),
            ],
            [
                'user_id' => $classRep->id ?? null,
                'room_id' => $room->id ?? null,
                'schedule_id' => $schedule->id ?? null,
                'room_claim_id' => null,
                'class_group_id' => $classGroupId,
                'event_type' => 'SCAN_SUCCESS',
                'metadata' => json_encode([
                    'user_name' => $classRep->name ?? 'Ketua Kelas',
                    'room_name' => $roomName,
                    'subject_name' => $courseName,
                ]),
                'created_at' => $now->copy()->subMinutes(5),
                'updated_at' => $now->copy()->subMinutes(5),
            ],
            [
                'user_id' => null,
                'room_id' => $room->id ?? null,
                'schedule_id' => $schedule->id ?? null,
                'room_claim_id' => null,
                'class_group_id' => $classGroupId,
                'event_type' => 'QUORUM_REACHED',
                'metadata' => json_encode([
                    'subject_name' => $courseName,
                    'room_name' => $roomName,
                    'quorum_count' => 5,
                ]),
                'created_at' => $now->copy()->subMinutes(8),
                'updated_at' => $now->copy()->subMinutes(8),
            ],
        ]);

        $this->command?->info('DashboardMahasiswaSeeder berhasil: data aktivitas mahasiswa ditambahkan.');
    }
}
