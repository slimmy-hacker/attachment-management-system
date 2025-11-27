<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentStudent extends Model
{
    protected $guarded = [];

    public function attachment() {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
