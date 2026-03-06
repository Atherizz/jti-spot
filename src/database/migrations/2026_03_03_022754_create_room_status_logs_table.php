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
        Schema::create('room_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('room_id');
            $table->string('previous_status', 20);
            $table->string('new_status', 20);
            $table->string('triggered_by', 255);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_status_logs');
    }
};
