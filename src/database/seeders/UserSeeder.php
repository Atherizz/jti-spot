<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Fixed accounts ────────────────────────────────────────────
        DB::table('users')->insertOrIgnore([
            [
                'name'               => 'Admin User',
                'reg_number'         => '12345678',
                'email'              => 'admin@example.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'remember_token'     => Str::random(10),
                'role'               => 'admin',
                'class_group_id'     => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Mahasiswa',
                'reg_number'         => '2441070202',
                'email'              => 'mahasiswa@example.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'remember_token'     => Str::random(10),
                'role'               => 'student',
                'class_group_id'     => ClassGroup::where('name', '2F')->where('major', 'TI')->value('id'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ketua Kelas',
                'reg_number'         => '2441070201',
                'email'              => 'ketua@example.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'remember_token'     => Str::random(10),
                'role'               => 'class_rep',
                'class_group_id'     => ClassGroup::where('name', '2F')->where('major', 'TI')->value('id'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ketua Kelas 2',
                'reg_number'         => '2441070203',
                'email'              => 'ketua2@example.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'remember_token'     => Str::random(10),
                'role'               => 'class_rep',
                'class_group_id'     => ClassGroup::where('name', '2B')->where('major', 'TI')->value('id'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Ketua Kelas 3',
                'reg_number'         => '2441070204',
                'email'              => 'ketua3@example.com',
                'email_verified_at'  => now(),
                'password'           => Hash::make('password'),
                'remember_token'     => Str::random(10),
                'role'               => 'class_rep',
                'class_group_id'     => ClassGroup::where('name', '2H')->where('major', 'TI')->value('id'),
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);

        // ── Sim users: 10 per class group that has at least one schedule ──
        $classGroups = DB::table('class_groups')
            ->join('schedules', 'class_groups.id', '=', 'schedules.class_group_id')
            ->select('class_groups.id', 'class_groups.name', 'class_groups.major')
            ->distinct()
            ->orderBy('class_groups.major')
            ->orderBy('class_groups.name')
            ->get();

        $simUsers      = [];
        $regSeq        = 9000000001;
        $hashedPassword = Hash::make('password'); // hash sekali, reuse untuk semua sim user

        foreach ($classGroups as $group) {
            $major = strtolower($group->major);
            $kelas = strtolower(str_replace(' ', '_', $group->name));

            for ($slot = 1; $slot <= 10; $slot++) {
                $email = "sim.{$major}.{$kelas}.{$slot}@example.com";
                $role  = $slot === 1 ? 'class_rep' : 'student';

                $simUsers[] = [
                    'name'               => "Sim {$group->major} {$group->name} #{$slot}",
                    'reg_number'         => (string) $regSeq++,
                    'email'              => $email,
                    'email_verified_at'  => now(),
                    'password'           => $hashedPassword,
                    'remember_token'     => Str::random(10),
                    'role'               => $role,
                    'class_group_id'     => $group->id,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        // insertOrIgnore: skip rows whose email or reg_number already exists
        foreach (array_chunk($simUsers, 100) as $chunk) {
            DB::table('users')->insertOrIgnore($chunk);
        }

        $total = DB::table('users')->where('email', 'like', 'sim.%@example.com')->count();
        $this->command->info("UserSeeder: {$total} sim users in database.");
    }
}
