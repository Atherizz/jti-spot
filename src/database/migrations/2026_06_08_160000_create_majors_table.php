<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
        });

        // Seed from existing unique majors in class_groups
        $existingMajors = DB::table('class_groups')
            ->select('major')
            ->distinct()
            ->whereNotNull('major')
            ->where('major', '!=', '')
            ->pluck('major');

        foreach ($existingMajors as $majorName) {
            DB::table('majors')->insert([
                'name' => $majorName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
