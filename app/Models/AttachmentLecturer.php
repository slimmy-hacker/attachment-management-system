<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttachmentLecturer extends Model
{
    protected $guarded = [];

    public function attachment() {
        return $this->belongsTo(Attachment::class, 'attachment_id');
    }
    public function lecturer() {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }

    public function department() {
        return $this->belongsTo(AdministrativeUnit::class, 'department_id');
    }
}
