<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // I already added these by hand in tinker, so only add if missing.
            // This way it works on your PC AND on your teammates' PCs.
            if (! Schema::hasColumn('locations', 'status')) {
                $table->string('status')->default('active');
            }
            if (! Schema::hasColumn('locations', 'type')) {
                $table->string('type')->nullable();
            }
            if (! Schema::hasColumn('locations', 'map')) {
                $table->string('map')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // remove only the columns we added
            $table->dropColumn(['status', 'type', 'map']);
        });
    }
};