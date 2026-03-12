<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classGroups = [];

        // Tingkat 1-4
        for ($level = 1; $level <= 4; $level++) {
            for ($i = 0; $i < 7; $i++) {
                $className = $level . chr(65 + $i); 
                $classGroups[] = [
                    'name' => $className,
                    'major' => 'SIB',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            for ($i = 0; $i < 9; $i++) {
                $className = $level . chr(65 + $i); 
                $classGroups[] = [
                    'name' => $className,
                    'major' => 'TI',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $specialClasses = [
            ['name' => 'AJ', 'major' => 'TI'],
        ];

        foreach ($specialClasses as $class) {
            $classGroups[] = array_merge($class, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::table('class_groups')->insert($classGroups);
    }
}
