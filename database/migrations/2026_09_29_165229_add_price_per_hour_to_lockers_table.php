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
        Schema::table('lockers', function (Blueprint $table) {
            $table->decimal('price_per_hour', 10, 2)->default(0)->after('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lockers', function (Blueprint $table) {
            $table->dropColumn('price_per_hour');
        });
    }
};
