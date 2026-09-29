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

            // Locker that needs maintenance
            $table->foreignId('locker_id')
                ->constrained('lockers')
                ->onDelete('cascade');

            // Reason for maintenance
            $table->string('reason');

            // User/staff who reported the maintenance
            $table->foreignId('reportByUser_id')
                ->constrained('users')
                ->onDelete('cascade');

            // User/staff who solved the maintenance
            $table->foreignId('solveByUser_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Maintenance status
            $table->string('status')
                ->default('pending');

            // When the problem was reported
            $table->timestamp('report_at')
                ->nullable();

            // When the problem was solved
            $table->timestamp('solve_at')
                ->nullable();

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

