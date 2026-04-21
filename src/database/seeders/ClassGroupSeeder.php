<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classGroups = [];
        $generatedTokens = [];

        $existingTokens = DB::table('class_groups')
            ->whereNotNull('access_token')
            ->pluck('access_token')
            ->all();

        foreach ($existingTokens as $existingToken) {
            $generatedTokens[(string) $existingToken] = true;
        }

        $buildToken = function (string $major, string $className) use (&$generatedTokens): string {
            $prefix = strtoupper($major . $className);

            do {
                $candidateToken = $prefix . '-' . strtolower(Str::random(6));
            } while (isset($generatedTokens[$candidateToken]));

            $generatedTokens[$candidateToken] = true;

            return $candidateToken;
        };

        // Tingkat 1-4
        for ($level = 1; $level <= 4; $level++) {
            for ($i = 0; $i < 7; $i++) {
                $className = $level . chr(65 + $i); 
                $classGroups[] = [
                    'name' => $className,
                    'major' => 'SIB',
                    'access_token' => $buildToken('SIB', $className),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            for ($i = 0; $i < 9; $i++) {
                $className = $level . chr(65 + $i); 
                $classGroups[] = [
                    'name' => $className,
                    'major' => 'TI',
                    'access_token' => $buildToken('TI', $className),
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
                'access_token' => $buildToken($class['major'], $class['name']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $existingClassCount = DB::table('class_groups')->count();

        if ($existingClassCount === 0) {
            DB::table('class_groups')->insert($classGroups);

            return;
        }

        $classGroupsWithoutToken = DB::table('class_groups')
            ->whereNull('access_token')
            ->orWhere('access_token', '')
            ->get(['id', 'major', 'name']);

        foreach ($classGroupsWithoutToken as $classGroupWithoutToken) {
            DB::table('class_groups')
                ->where('id', $classGroupWithoutToken->id)
                ->update([
                    'access_token' => $buildToken((string) $classGroupWithoutToken->major, (string) $classGroupWithoutToken->name),
                    'updated_at' => now(),
                ]);
        }
    }
}
