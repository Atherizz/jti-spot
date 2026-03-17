<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('class_group_id')->nullable()->constrained()->nullOnDelete();
            
            // 2. TIPE EVENT 
            // Cth: 'SCAN_SUCCESS', 'SCAN_FAILED', 'QUORUM_REACHED', 'ROOM_CLAIMED'
            $table->string('event_type', 50)->index(); 
            
            // 3. PAYLOAD DINAMIS (Kunci UI Fleksibel)
            $table->json('metadata')->nullable(); 
            /*
             * KONTRAK METADATA BERDASARKAN EVENT_TYPE:
             * * A. event_type: 'SCAN_SUCCESS'
             * Tujuan UI: "Savero verified attendance in LPR 7 (Web Programming)"
             * Metadata: {
             * "user_name": "Savero",
             * "room_name": "LPR 7",
             * "subject_name": "Web Programming"
             * }
             * * B. event_type: 'QUORUM_REACHED'
             * Tujuan UI: "Quorum reached for Web Programming. Class officially started!"
             * Metadata: {
             * "subject_name": "Web Programming",
             * "room_name": "LPR 7",
             * "quorum_count": 5
             * }
             * * C. event_type: 'SCAN_FAILED' (Hanya untuk audit admin/developer)
             * Metadata: {
             * "user_name": "Budi",
             * "reason": "GPS location out of bounds (150m)",
             * "qr_token": "invalid_xyz123"
             * }
             */

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};