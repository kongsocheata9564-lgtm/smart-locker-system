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
    $table->foreignId('locker_id')->constrained()->cascadeOnDelete();
    $table->string('reason');
    $table->foreignId('reported_by_user_id')->constrained('users');
    $table->foreignId('solved_by_user_id')->nullable()->constrained('users');
    $table->string('status')->default('pending');
    $table->timestamp('reported_at')->useCurrent();
    $table->timestamp('solved_at')->nullable();
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
