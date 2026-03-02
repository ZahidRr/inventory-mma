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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('serial_number')->unique();
            $table->string('client_unit')->nullable(); // Diisi saat instalasi (Contoh: Tower A-10)
            $table->enum('status', ['MASUK', 'KELUAR', 'RUSAK'])->default('MASUK');
            $table->timestamp('installed_at')->nullable(); // Untuk mencatat kapan dipasang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_numbers');
    }
};
