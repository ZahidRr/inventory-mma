<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('package');
            $table->enum('status', ['PENDING', 'ACTIVE', 'NONAKTIF'])->default('PENDING');
            $table->foreignId('serial_number_id')->nullable()->constrained('serial_numbers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
