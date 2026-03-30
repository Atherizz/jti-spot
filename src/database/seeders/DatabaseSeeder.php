<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
            ClassGroupSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            ScheduleSeeder::class,
            DashboardMahasiswaSeeder::class,
            ]
    );
    }
}
