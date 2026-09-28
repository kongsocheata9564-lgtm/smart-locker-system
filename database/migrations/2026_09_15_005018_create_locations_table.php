<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();                 // used in the URL: /locations/abc-mall
            $table->string('category');                       // Shopping Mall, Library, Sports Center, Building
            $table->string('address');
            $table->decimal('price_per_hour', 6, 2)->default(0);
            $table->unsignedInteger('total_lockers')->default(0);
            $table->unsignedInteger('free_lockers')->default(0); // temporary, later count from the lockers table
            $table->decimal('rating', 2, 1)->nullable();      // admin doesn't set this, card hides the star if empty
            $table->string('image')->nullable();              // path of the uploaded photo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
