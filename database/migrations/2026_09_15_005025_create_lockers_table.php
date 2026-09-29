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
         Schema::create('lockers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // simpler than locker_name
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->string('password')->nullable(); // Hashed if physical PIN
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Current assigned user
            $table->string('status')->default('available'); // enum: available, occupied, maintenance
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lockers');
    }
};
