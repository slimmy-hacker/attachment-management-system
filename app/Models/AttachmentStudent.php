<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentStudent extends Model
{
    protected $guarded = [];

    public function attachment() {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
    public function attachment_lecturer()
    {
        return $this->belongsTo(AttachmentLecturer::class, 'lecturer_id');
    }

    public function industrialSupervisor()
    {
        return $this->belongsTo(IndustrialSupervisor::class, 'industrial_supervisor_id');
    }
    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function program()
    {
        return $this->hasOneThrough(
            AdministrativeUnit::class,     // Final: department
            Student::class,                // Intermediate: student
            'id',                          // Local key on students
            'id',                          // Local key on admin units
            'student_id',                  // FK on attachment_students
            'program_id'                   // FK on students table → program
        )->with('parent');
    }
    public function getDepartmentAttribute()
    {
        return $this->student?->program?->parent;
    }
   public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class, 'attachment_student_id');
    }




}
