<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentAssessmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachment_assessments', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('industrial_supervisor_id')->nullable();

        
            $table->unsignedBigInteger('school_supervisor_id')->nullable();

            /**
             * ------------------------------
             * Industrial Supervisor Fields
             * ------------------------------
             */
            $table->integer('attendance_marks')->nullable();
            $table->text('attendance_remarks')->nullable();

            // Additional industrial assessment fields
            $table->integer('work_quality_marks')->nullable();
            $table->text('work_quality_remarks')->nullable();

            $table->integer('behaviour_marks')->nullable();
            $table->text('behaviour_remarks')->nullable();

            $table->integer('punctuality_marks')->nullable();
            $table->text('punctuality_remarks')->nullable();

            /**
             * ------------------------------
             * School Supervisor Fields
             * ------------------------------
             */
            $table->integer('practical_marks')->nullable();
            $table->text('practical_remarks')->nullable();

            // Additional school assessment fields
            $table->integer('report_marks')->nullable();
            $table->text('report_remarks')->nullable();

            $table->integer('presentation_marks')->nullable();
            $table->text('presentation_remarks')->nullable();

            $table->integer('overall_marks')->nullable();
            $table->text('overall_remarks')->nullable();

            $table->timestamps();

            // Foreign keys (optional)
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('industrial_supervisor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('school_supervisor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachment_assessments');
    }
}
