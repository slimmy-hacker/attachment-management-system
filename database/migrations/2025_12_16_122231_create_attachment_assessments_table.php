<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attachment_assessments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('attachment_student_id')->constrained()->cascadeOnDelete();
           


    $table->unsignedTinyInteger('practical_orientation_marks')->default(0);
$table->text('practical_orientation_remarks')->nullable();

$table->unsignedTinyInteger('intellectual_activity_marks')->default(0);
$table->text('intellectual_activity_remarks')->nullable();

$table->unsignedTinyInteger('independence_marks')->default(0);
$table->text('independence_remarks')->nullable();

$table->unsignedTinyInteger('communication_marks')->default(0);
$table->text('communication_remarks')->nullable();

$table->unsignedTinyInteger('technology_and_skills_marks')->default(0);
$table->text('technology_and_skills_remarks')->nullable();

$table->unsignedTinyInteger('innovativeness_marks')->default(0);
$table->text('innovativeness_remarks')->nullable();

// ===== Work Discipline =====
$table->unsignedTinyInteger('punctuality_marks')->default(0);
$table->text('punctuality_remarks')->nullable();

$table->unsignedTinyInteger('attendance_marks')->default(0);
$table->text('attendance_remarks')->nullable();

// ===== Skills & Knowledge =====
$table->unsignedTinyInteger('basic_skills_marks')->default(0);
$table->text('basic_skills_remarks')->nullable();

$table->unsignedTinyInteger('general_office_applications_marks')->default(0);
$table->text('general_office_applications_remarks')->nullable();

$table->unsignedTinyInteger('technical_applications_marks')->default(0);
$table->text('technical_applications_remarks')->nullable();

$table->unsignedTinyInteger('area_of_specialization_marks')->default(0);
$table->text('area_of_specialization_remarks')->nullable();

$table->unsignedTinyInteger('scientific_and_technical_knowledge_marks')->default(0);
$table->text('scientific_and_technical_knowledge_remarks')->nullable();

// ===== Personal Attributes =====
$table->unsignedTinyInteger('intelligence_marks')->default(0);
$table->text('intelligence_remarks')->nullable();

$table->unsignedTinyInteger('learning_ability_marks')->default(0);
$table->text('learning_ability_remarks')->nullable();

$table->unsignedTinyInteger('responsibility_acceptance_marks')->default(0);
$table->text('responsibility_acceptance_remarks')->nullable();

$table->unsignedTinyInteger('improvisation_marks')->default(0);
$table->text('improvisation_remarks')->nullable();

$table->unsignedTinyInteger('environment_adjustment_marks')->default(0);
$table->text('environment_adjustment_remarks')->nullable();

$table->unsignedTinyInteger('dependability_and_reliability_marks')->default(0);
$table->text('dependability_and_reliability_remarks')->nullable();

$table->unsignedTinyInteger('organization_and_planning_marks')->default(0);
$table->text('organization_and_planning_remarks')->nullable();

$table->unsignedTinyInteger('effective_time_use_marks')->default(0);
$table->text('effective_time_use_remarks')->nullable();

$table->unsignedSmallInteger('total_marks')->default(0);
$table->text('overall_remarks')->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachment_assessments');
    }
};