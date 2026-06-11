<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allowed_ips', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100)->comment('Nama deskriptif, misal: WiFi Utama Gedung A');
            $table->string('ip_address', 50)->comment('IP tunggal atau CIDR range, misal: 103.113.118.0/23');
            $table->boolean('is_active')->default(true)->comment('Toggle aktif/nonaktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allowed_ips');
    }
};
