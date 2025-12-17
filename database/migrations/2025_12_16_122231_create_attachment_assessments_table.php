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
            $table->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();

           // ===== Practical & Professional Skills =====
$table->unsignedTinyInteger('practical_orientation_marks')->default(0);
$table->text('practical_orientation_remarks')->default('');

$table->unsignedTinyInteger('intellectual_activity_marks')->default(0);
$table->text('intellectual_activity_remarks')->default('');

$table->unsignedTinyInteger('independence_marks')->default(0);
$table->text('independence_remarks')->default('');

$table->unsignedTinyInteger('communication_marks')->default(0);
$table->text('communication_remarks')->default('');

$table->unsignedTinyInteger('technology_and_skills_marks')->default(0);
$table->text('technology_and_skills_remarks')->default('');

$table->unsignedTinyInteger('innovativeness_marks')->default(0);
$table->text('innovativeness_remarks')->default('');

// ===== Work Discipline =====
$table->unsignedTinyInteger('punctuality_marks')->default(0);
$table->text('punctuality_remarks')->default('');

$table->unsignedTinyInteger('attendance_marks')->default(0);
$table->text('attendance_remarks')->default('');

// ===== Skills & Knowledge =====
$table->unsignedTinyInteger('basic_skills_marks')->default(0);
$table->text('basic_skills_remarks')->default('');

$table->unsignedTinyInteger('general_office_applications_marks')->default(0);
$table->text('general_office_applications_remarks')->default('');

$table->unsignedTinyInteger('technical_applications_marks')->default(0);
$table->text('technical_applications_remarks')->default('');

$table->unsignedTinyInteger('area_of_specialization_marks')->default(0);
$table->text('area_of_specialization_remarks')->default('');

$table->unsignedTinyInteger('scientific_and_technical_knowledge_marks')->default(0);
$table->text('scientific_and_technical_knowledge_remarks')->default('');

// ===== Personal Attributes =====
$table->unsignedTinyInteger('intelligence_marks')->default(0);
$table->text('intelligence_remarks')->default('');

$table->unsignedTinyInteger('learning_ability_marks')->default(0);
$table->text('learning_ability_remarks')->default('');

$table->unsignedTinyInteger('responsibility_acceptance_marks')->default(0);
$table->text('responsibility_acceptance_remarks')->default('');

$table->unsignedTinyInteger('improvisation_marks')->default(0);
$table->text('improvisation_remarks')->default('');

$table->unsignedTinyInteger('environment_adjustment_marks')->default(0);
$table->text('environment_adjustment_remarks')->default('');

$table->unsignedTinyInteger('dependability_and_reliability_marks')->default(0);
$table->text('dependability_and_reliability_remarks')->default('');

$table->unsignedTinyInteger('organization_and_planning_marks')->default(0);
$table->text('organization_and_planning_remarks')->default('');

$table->unsignedTinyInteger('effective_time_use_marks')->default(0);
$table->text('effective_time_use_remarks')->default('');

// ===== Overall =====
$table->unsignedSmallInteger('total_marks')->default(0);
$table->text('overall_remarks')->default('');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachment_assessments');
    }
};
