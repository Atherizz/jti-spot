<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_claims', function (Blueprint $table) {
            $table->foreignId('claimed_by_user_id')->constrained('users')->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            
            $table->dropColumn('status'); 
        });

        Schema::table('room_claims', function (Blueprint $table) {
            $table->enum('status', ['pending_quorum', 'locked', 'cancelled', 'completed'])
                  ->default('pending_quorum');
        });
    }

    public function down(): void
    {
        Schema::table('room_claims', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('room_claims', function (Blueprint $table) {
            $table->dropForeign(['claimed_by_user_id']);
            $table->dropColumn('claimed_by_user_id');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');

            $table->enum('status', ['pending_quorum', 'locked', 'cancelled'])
                  ->default('pending_quorum');
        });
    }
};