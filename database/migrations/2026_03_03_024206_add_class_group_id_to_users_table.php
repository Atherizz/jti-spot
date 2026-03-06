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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'class_rep', 'admin'])
                  ->default('student');

            $table->foreignId('class_group_id')
                  ->nullable() 
                  ->constrained('class_groups') 
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_group_id']);
            $table->dropColumn(['role', 'class_group_id']);
        });
    }
};