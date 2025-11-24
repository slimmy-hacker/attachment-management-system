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
        Schema::create('attachment_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');   // ✔ correct
            $table->unsignedBigInteger('attachment_id'); // ✔ correct

            $table->string('company_id')->nullable();
            $table->string('lecturer_id')->nullable();
            $table->string('industrial_supervisor_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('report')->nullable();
            $table->string('report_file')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['student_id', 'attachment_id']);

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_students');
    }
};
