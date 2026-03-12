<?php

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
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedTinyInteger('start_period')->after('day_of_week');
            $table->unsignedTinyInteger('end_period')->after('start_period');
        });

        DB::statement('ALTER TABLE schedules ADD CONSTRAINT check_start_period_range CHECK (start_period >= 1 AND start_period <= 12)');
        DB::statement('ALTER TABLE schedules ADD CONSTRAINT check_end_period_range CHECK (end_period >= 1 AND end_period <= 12)');
        
        DB::statement('ALTER TABLE schedules ADD CONSTRAINT check_period_order CHECK (start_period <= end_period)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            DB::statement('ALTER TABLE schedules DROP CONSTRAINT IF EXISTS check_start_period_range');
            DB::statement('ALTER TABLE schedules DROP CONSTRAINT IF EXISTS check_end_period_range');
            DB::statement('ALTER TABLE schedules DROP CONSTRAINT IF EXISTS check_period_order');

            $table->dropColumn(['start_period', 'end_period']);
        });
    }
};