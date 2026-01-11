<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_grades', function (Blueprint $table) {
            $table->id();
            $table->string('public_service_group'); // U, T, S, etc
            $table->string('dekut_grade');          // 18, 15&16, etc
            $table->string('designation');          // Job title
            $table->integer('daily_allowance');     // Amount in KES
            $table->string('applies_to')->default('All Towns');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_grades');
    }
};
