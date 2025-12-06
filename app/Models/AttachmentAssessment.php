<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',

        // Industrial Supervisor fields
        'attendance_marks',
        'attendance_remarks',
        'punctuality_marks',
        'punctuality_remarks',
        'work_quality_marks',
        'work_quality_remarks',
        'teamwork_marks',
        'teamwork_remarks',
        'discipline_marks',
        'discipline_remarks',

        // School Supervisor fields
        'practical_marks',
        'practical_remarks',
        'report_marks',
        'report_remarks',
        'presentation_marks',
        'presentation_remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
