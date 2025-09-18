<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('department_code');
            $table->string('school_code');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
