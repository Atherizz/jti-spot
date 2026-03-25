<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    
         User::insert([
            [
                'name' => 'Admin User',
                'reg_number' => '12345678',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(),
                'role' => 'admin',
                'class_group_id' => null
            ],
            [
                'name' => 'Mahasiswa',
                'reg_number' => '2441070202',
                'email' => 'mahasiswa@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(),
                'role' => 'student',
                'class_group_id' => ClassGroup::where('name', '2F')->where('major', 'TI')->first()->id
            ],
            [
                'name' => 'Ketua Kelas',
                'reg_number' => '2441070201',
                'email' => 'ketua@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(),
                'role' => 'class_rep',
                'class_group_id' => ClassGroup::where('name', '2F')->where('major', 'TI')->first()->id
            ]

        ]);

    }
}
