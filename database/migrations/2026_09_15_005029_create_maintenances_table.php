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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locker_id')->constrained('lockers')->onDelete('cascade');
            $table->string('reason');
            $table->unsignedBigInteger('reportByUser_id');
            $table->foreign('reportByUser_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sovleByUser_id')->nullable();
            $table->foreign('sovleByUser_id')->references('id')->on('users')->nullOnDelete();
            $table->string('status')->default('pending');
            $table->timestamp('report_at')->nullable();
            $table->timestamp('solve_at')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
