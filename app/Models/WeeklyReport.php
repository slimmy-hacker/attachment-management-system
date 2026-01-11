<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Always append 'status' when the model is serialized
    protected $appends = ['status'];

    /**
     * Get the computed status attribute.
     *
     * Rules (example, adjust to your logic):
     * - If weekly_report is empty => status = 'pending_student'
     * - If weekly_report is filled, industrial_supervisor_comment empty => 'pending_industrial'
     * - If industrial_supervisor_comment filled, lecturer_comment empty => 'pending_lecturer'
     * - If all filled => 'completed'
     */
    public function getStatusAttribute()
    {
        if (empty($this->weekly_report)) {
            return 'pending_student';
        }

        if (empty($this->industrial_supervisor_comment)) {
            return 'pending_industrial';
        }

        if (empty($this->lecturer_comment)) {
            return 'pending_lecturer';
        }

        return 'completed';
    }


    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }
     public function attachmentStudent()
    {
        return $this->belongsTo(AttachmentStudent::class, 'attachment_student_id');
    }

}
