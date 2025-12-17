<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment_student_id',

            // --- Practical & Professional Skills ---
        'practical_orientation_marks',
        'practical_orientation_remarks',
        'intellectual_activity_marks',
        'intellectual_activity_remarks',
        'independence_marks',
        'independence_remarks',
        'communication_marks',
        'communication_remarks',
        'technology_and_skills_marks',
        'technology_and_skills_remarks',
        'innovativeness_marks',
        'innovativeness_remarks',

        // --- Work Discipline ---
        'punctuality_marks',
        'punctuality_remarks',
        'attendance_marks',
        'attendance_remarks',

        // --- Skills & Knowledge ---
        'basic_skills_marks',
        'basic_skills_remarks',
        'general_office_applications_marks',
        'general_office_applications_remarks',
        'technical_applications_marks',
        'technical_applications_remarks',
        'area_of_specialization_marks',
        'area_of_specialization_remarks',
        'scientific_and_technical_knowledge_marks',
        'scientific_and_technical_knowledge_remarks',

        // --- Personal Attributes ---
        'intelligence_marks',
        'intelligence_remarks',
        'learning_ability_marks',
        'learning_ability_remarks',
        'responsibility_acceptance_marks',
        'improvisation_marks',
        'improvisation_remarks',
        'environment_adjustment_marks',
        'environment_adjustment_remarks',
        'dependability_and_reliability_marks',
        'dependability_and_reliability_remarks',
        'organization_and_planning_marks',
        'organization_and_planning_remarks',
        'effective_time_use_marks',
        'effective_time_use_remarks',

        // --- Overall ---
        'total_marks',
        'overall_remarks',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    protected $guarded = [];

    public function attachmentStudent()
    {
        // FK is attachment_student_id in attachment_assessments table
        return $this->belongsTo(AttachmentStudent::class, 'attachment_student_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function industrialSupervisor()
    {
        return $this->belongsTo(IndustrialSupervisor::class, 'industrial_supervisor_id');
    }
     public function getLecturerTotalMarksAttribute()
    {
        return 
            ($this->practical_orientation_marks ?? 0) +
            ($this->intellectual_activity_marks ?? 0) +
            ($this->independence_marks ?? 0) +
            ($this->communication_marks ?? 0) +
            ($this->technology_and_skills_marks ?? 0) +
            ($this->innovativeness_marks ?? 0);
    }

    // Accessor for industrial supervisor total marks (sum of all industrial supervisor marks)
    public function getIndustrialSupervisorTotalMarksAttribute()
    {
        return
            ($this->punctuality_marks ?? 0) +
            ($this->attendance_marks ?? 0) +
            ($this->basic_skills_marks ?? 0) +
            ($this->general_office_applications_marks ?? 0) +
            ($this->technical_applications_marks ?? 0) +
            ($this->area_of_specialization_marks ?? 0) +
            ($this->scientific_and_technical_knowledge_marks ?? 0) +
            ($this->intelligence_marks ?? 0) +
            ($this->learning_ability_marks ?? 0) +
            ($this->responsibility_acceptance_marks ?? 0) +
            ($this->improvisation_marks ?? 0) +
            ($this->environment_adjustment_marks ?? 0) +
            ($this->dependability_and_reliability_marks ?? 0) +
            ($this->organization_and_planning_marks ?? 0) +
            ($this->effective_time_use_marks ?? 0);
    }
}
