<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quorum_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('room_id');
            $table->foreignId('schedule_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('claim_id')->nullable()->constrained('room_claims')->onDelete('cascade');
            $table->date('scanned_date');
            $table->timestamp('scanned_at')->useCurrent();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->unique(['user_id', 'schedule_id', 'scanned_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quorum_scans');
    }
};
