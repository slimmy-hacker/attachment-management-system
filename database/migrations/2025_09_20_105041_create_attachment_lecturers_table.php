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
        Schema::create('attachment_lecturers', function (Blueprint $table) {

            $table->id();
            $table->integer('lecturer_id');
            $table->integer('attachment_id');
            $table->integer('department_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['lecturer_id','attachment_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_lecturers');
    }
};
