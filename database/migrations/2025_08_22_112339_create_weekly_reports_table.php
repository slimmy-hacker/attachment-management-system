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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('attachment_student_id');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->integer('week_id');
            $table->text('weekly_report')->nullable();
            $table->text('industrial_supervisor_comment')->nullable();
            $table->text('lecturer_comment')->nullable();
            $table->unique(['attachment_student_id', 'week_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
