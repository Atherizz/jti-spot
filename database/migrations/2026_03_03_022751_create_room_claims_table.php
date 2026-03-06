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
        Schema::create('room_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('room_id');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('claimer_group_id')->constrained('class_groups')->onDelete('cascade');
            $table->date('claim_date');
            $table->enum('status', ['pending_quorum', 'locked', 'cancelled'])->default('pending_quorum');
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_claims');
    }
};
