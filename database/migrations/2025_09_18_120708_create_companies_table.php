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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->unique();       // Company Name
            $table->string('alias')->unique();      // Company Alias
            $table->string('parent_company')->nullable();     // Company Branch
            $table->string('address');
            $table->string('email')->unique();
            $table->string('contact')->unique();
            $table->unsignedBigInteger('county_id');     // County (dropdown)
            $table->unsignedBigInteger('sub_county_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable(); // Subcounty
            $table->string('street');
            $table->string('building');
            $table->decimal('latitude', 10, 7)->nullable();   // Latitude
            $table->decimal('longitude', 10, 7)->nullable();  // Longitude
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
