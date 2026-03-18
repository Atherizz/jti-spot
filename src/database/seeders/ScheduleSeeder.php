<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Helper to get room_id by name
        $roomId = function (string $name): int {
            return DB::table('rooms')->where('name', $name)->value('id');
        };

        // Helper to get class_group_id by major and name separately
        $classGroupId = function (string $major, string $name): int {
            $id = DB::table('class_groups')
                ->where('major', $major)
                ->where('name', $name)
                ->value('id');

            if (! $id) {
                throw new \RuntimeException(
                    "class_groups not found: major='{$major}', name='{$name}'"
                );
            }

            return (int) $id;
        };

        $schedules = [];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 3,
            'start_time'     => '07:00:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '4I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 6,
            'start_time'     => '10:30:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 1'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 2,
            'end_period'     => 5,
            'start_time'     => '07:50:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 2,
            'end_period'     => 6,
            'start_time'     => '07:50:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 10,
            'end_period'     => 12,
            'start_time'     => '15:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 2'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 12,
            'end_period'     => 12,
            'start_time'     => '17:10:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 2,
            'end_period'     => 4,
            'start_time'     => '07:50:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 8,
            'end_period'     => 11,
            'start_time'     => '13:40:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '4B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '4E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 9,
            'start_time'     => '10:30:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '4E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 3'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 8,
            'end_period'     => 12,
            'start_time'     => '13:40:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '4C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 2,
            'end_period'     => 6,
            'start_time'     => '07:50:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '4C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '4F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 6,
            'end_period'     => 9,
            'start_time'     => '11:20:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 4,
            'start_time'     => '08:40:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '4G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 6,
            'start_time'     => '10:30:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 4'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 5'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 8,
            'end_period'     => 10,
            'start_time'     => '13:40:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 2,
            'end_period'     => 4,
            'start_time'     => '07:50:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 8,
            'end_period'     => 11,
            'start_time'     => '13:40:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 2,
            'end_period'     => 5,
            'start_time'     => '07:50:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 6'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 6,
            'end_period'     => 8,
            'start_time'     => '11:20:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 8,
            'end_period'     => 11,
            'start_time'     => '13:40:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 7'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '4F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 11,
            'end_period'     => 12,
            'start_time'     => '16:20:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 1'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 10,
            'start_time'     => '14:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 9,
            'start_time'     => '10:30:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '4D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 4,
            'start_time'     => '08:40:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 9,
            'start_time'     => '10:30:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 10,
            'end_period'     => 12,
            'start_time'     => '15:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 1'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 10,
            'start_time'     => '14:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 2'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', 'AJ'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 2,
            'end_period'     => 6,
            'start_time'     => '07:50:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 5,
            'start_time'     => '08:40:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('TI', 'AJ'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Informasi 3'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 11,
            'end_period'     => 12,
            'start_time'     => '16:20:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '4I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 6,
            'end_period'     => 9,
            'start_time'     => '11:20:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '4H'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 5,
            'start_time'     => '08:40:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 2'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 3'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 1'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('TI', '4B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 2'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 11,
            'end_period'     => 12,
            'start_time'     => '16:20:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 3'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', 'AJ'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 4'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 5'),
            'class_group_id' => $classGroupId('SIB', '4G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 6,
            'end_period'     => 10,
            'start_time'     => '11:20:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', 'AJ'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 2,
            'end_period'     => 4,
            'start_time'     => '07:50:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 9,
            'start_time'     => '10:30:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 3,
            'start_time'     => '07:00:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 4,
            'end_period'     => 8,
            'start_time'     => '09:40:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 6'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PBD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 2,
            'end_period'     => 4,
            'start_time'     => '07:50:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 7'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 6,
            'start_time'     => '10:30:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 8,
            'end_period'     => 12,
            'start_time'     => '13:40:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'PASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Pemrograman 8'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 2,
            'end_period'     => 6,
            'start_time'     => '07:50:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '3A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 9,
            'start_time'     => '12:50:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 3,
            'start_time'     => '07:00:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 4,
            'end_period'     => 5,
            'start_time'     => '09:40:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 1'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '1H'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'BD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PBD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 2'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 3,
            'start_time'     => '07:00:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 4,
            'end_period'     => 6,
            'start_time'     => '09:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '4G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '2C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'BIDA_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '4A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 2,
            'end_period'     => 6,
            'start_time'     => '07:50:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Sist Komp dan Jaringan 3'),
            'class_group_id' => $classGroupId('TI', '4F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '4D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '3F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 12,
            'start_time'     => '10:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 7,
            'start_time'     => '12:50:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab ERP'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 11,
            'end_period'     => 12,
            'start_time'     => '16:20:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '1A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'EP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PWL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'DW_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Kecerdasan Buatan 1'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '1E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 10,
            'start_time'     => '10:30:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '3B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SBB_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('TI', '2B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'POSI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PJK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 1'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'ADPSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '1F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'BD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '4H'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 6,
            'start_time'     => '10:30:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('SIB', '1B'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PTT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'AG_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'ASD_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ADBO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BIL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DUU_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('SIB', '2F'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'K3_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '1E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'SO_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 6,
            'start_time'     => '07:00:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('SIB', '2A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 9,
            'start_time'     => '12:50:00',
            'end_time'       => '15:20:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Visi Komputer 2'),
            'class_group_id' => $classGroupId('TI', '3B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 10,
            'end_period'     => 12,
            'start_time'     => '15:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PBF_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'ASD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('TI', 'AJ'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'BIPK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'DM_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('TI', '1C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'DA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('TI', '3C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 12,
            'start_time'     => '12:50:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'IOT_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '3E'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'KEP_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '1D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SO_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'EBSD_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Lab Proyek 4'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIDA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '1D'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'RPL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '1F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '4A'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '2E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 3,
            'end_period'     => 5,
            'start_time'     => '08:40:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 6,
            'end_period'     => 6,
            'start_time'     => '11:20:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '4A'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'BIPK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 1,
            'end_period'     => 5,
            'start_time'     => '07:00:00',
            'end_time'       => '11:20:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '3A'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 6,
            'end_period'     => 6,
            'start_time'     => '11:20:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '3E'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '4B'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 11,
            'end_period'     => 12,
            'start_time'     => '16:20:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'FS_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '2D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'PC_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('SIB', '1A'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 8'),
            'class_group_id' => $classGroupId('TI', '1B'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2A'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2H'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'APP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 2,
            'end_period'     => 3,
            'start_time'     => '07:50:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'KH_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 4,
            'end_period'     => 8,
            'start_time'     => '09:40:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'MAL_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'JK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '1G'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('SIB', '3D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 7,
            'end_period'     => 11,
            'start_time'     => '12:50:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 2,
            'start_time'     => '07:00:00',
            'end_time'       => '08:40:00',
            'course_name'    => 'BI_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '3D'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 3,
            'end_period'     => 6,
            'start_time'     => '08:40:00',
            'end_time'       => '12:10:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('SIB', '1C'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 7,
            'end_period'     => 8,
            'start_time'     => '12:50:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'KWN_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('Ruang Teori 9'),
            'class_group_id' => $classGroupId('TI', '2I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'KA_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('SIB', '2G'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 5,
            'end_period'     => 7,
            'start_time'     => '10:30:00',
            'end_time'       => '13:40:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('SIB', '3C'),
            'day_of_week'    => 1, // Senin
            'start_period'   => 7,
            'end_period'     => 10,
            'start_time'     => '12:50:00',
            'end_time'       => '16:20:00',
            'course_name'    => 'MHP_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '4E'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('SIB', '3G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'POSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('SIB', '1G'),
            'day_of_week'    => 2, // Selasa
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'PSI_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '4C'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 1,
            'end_period'     => 4,
            'start_time'     => '07:00:00',
            'end_time'       => '10:30:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '2F'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 5,
            'end_period'     => 8,
            'start_time'     => '10:30:00',
            'end_time'       => '14:30:00',
            'course_name'    => 'SK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('SIB', '2B'),
            'day_of_week'    => 3, // Rabu
            'start_period'   => 9,
            'end_period'     => 11,
            'start_time'     => '14:30:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'WK_SIB',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '4D'),
            'day_of_week'    => 4, // Kamis
            'start_period'   => 8,
            'end_period'     => 11,
            'start_time'     => '13:40:00',
            'end_time'       => '17:10:00',
            'course_name'    => 'PK_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '1I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 1,
            'end_period'     => 3,
            'start_time'     => '07:00:00',
            'end_time'       => '09:30:00',
            'course_name'    => 'AL_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        $schedules[] = [
            'room_id'        => $roomId('STUDIO_8B'),
            'class_group_id' => $classGroupId('TI', '3I'),
            'day_of_week'    => 5, // Jumat
            'start_period'   => 9,
            'end_period'     => 12,
            'start_time'     => '14:30:00',
            'end_time'       => '18:00:00',
            'course_name'    => 'CC_TI',
            'created_at'     => $now,
            'updated_at'     => $now,
        ];

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($schedules, 50) as $chunk) {
            DB::table('schedules')->insert($chunk);
        }
    }
}