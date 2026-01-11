<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    protected $fillable = [
        'attachment_student_id',
        'title',
        'content',
        'file_path',
        'is_submitted',
    ];

    public function attachmentStudent()
    {
        return $this->belongsTo(AttachmentStudent::class);
    }
}

