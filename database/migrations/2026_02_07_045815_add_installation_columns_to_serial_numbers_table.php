<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            // client_unit DIHAPUS dari sini karena sudah ada di create_serial_numbers_table
            $table->string('technician')->nullable(); 
            $table->integer('cable_length')->nullable();
            $table->date('work_date')->nullable(); // Pastikan ini ada
            // installed_at juga biasanya sudah ada, tapi jika belum biarkan saja
        });
    }

    public function down(): void
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->dropColumn(['technician', 'cable_length', 'work_date']);
        });
    }
};