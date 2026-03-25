<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            // Lantai 5
            ['room_code' => 'RT01',   'name' => 'Ruang Teori 1', 'floor' => 5],
            ['room_code' => 'RT02',   'name' => 'Ruang Teori 2', 'floor' => 5],
            ['room_code' => 'RT03',   'name' => 'Ruang Teori 3', 'floor' => 5],
            ['room_code' => 'RT04',   'name' => 'Ruang Teori 4', 'floor' => 5],
            ['room_code' => 'RT05',   'name' => 'Ruang Teori 5', 'floor' => 5],
            ['room_code' => 'RT06',   'name' => 'Ruang Teori 6', 'floor' => 5],
            ['room_code' => 'LPY1',   'name' => 'Lab Proyek 1', 'floor' => 5],

            // Lantai 6
            ['room_code' => 'LSI1',   'name' => 'Lab Sist Informasi 1', 'floor' => 6],
            ['room_code' => 'LSI2',   'name' => 'Lab Sist Informasi 2', 'floor' => 6],
            ['room_code' => 'LSI3',   'name' => 'Lab Sist Informasi 3', 'floor' => 6],
            ['room_code' => 'LPY2',   'name' => 'Lab Proyek 2', 'floor' => 6],
            ['room_code' => 'LPY3',   'name' => 'Lab Proyek 3', 'floor' => 6],

            // Lantai 7
            ['room_code' => 'LPR1',   'name' => 'Lab Pemrograman 1', 'floor' => 7],
            ['room_code' => 'LPR2',   'name' => 'Lab Pemrograman 2', 'floor' => 7],
            ['room_code' => 'LPR3',   'name' => 'Lab Pemrograman 3', 'floor' => 7],
            ['room_code' => 'LPR4',   'name' => 'Lab Pemrograman 4', 'floor' => 7],
            ['room_code' => 'LPR5',   'name' => 'Lab Pemrograman 5', 'floor' => 7],
            ['room_code' => 'LPR6',   'name' => 'Lab Pemrograman 6', 'floor' => 7],
            ['room_code' => 'LPR7',   'name' => 'Lab Pemrograman 7', 'floor' => 7],
            ['room_code' => 'LPR8',   'name' => 'Lab Pemrograman 8', 'floor' => 7],
            ['room_code' => 'LKJ1',   'name' => 'Lab Sist Komp dan Jaringan 1', 'floor' => 7],
            ['room_code' => 'LKJ2',   'name' => 'Lab Sist Komp dan Jaringan 2', 'floor' => 7],
            ['room_code' => 'LKJ3',   'name' => 'Lab Sist Komp dan Jaringan 3', 'floor' => 7],
            ['room_code' => 'LIG1',   'name' => 'Lab Visi Komputer 1', 'floor' => 7],
            ['room_code' => 'LIG2',   'name' => 'Lab Visi Komputer 2', 'floor' => 7],
            ['room_code' => 'LPY4',   'name' => 'Lab Proyek 4', 'floor' => 7],
            ['room_code' => 'LERP',   'name' => 'Lab ERP', 'floor' => 7],
            ['room_code' => 'LAI1',   'name' => 'Lab Kecerdasan Buatan 1', 'floor' => 7],

            // Lantai 8
            ['room_code' => 'RT08',   'name' => 'Ruang Teori 8', 'floor' => 8],
            ['room_code' => 'RT09',   'name' => 'Ruang Teori 9', 'floor' => 8],
            ['room_code' => 'STUDIO', 'name' => 'STUDIO_8B', 'floor' => 8],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->updateOrInsert(
                ['room_code' => $room['room_code']],
                [
                    'name'           => $room['name'],
                    'floor'          => $room['floor'],
                    'current_status' => 'available',
                    'qr_token'       => Str::random(32),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]
            );
        }
    }
}