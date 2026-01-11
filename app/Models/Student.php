<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $table = 'students';

    protected $guarded = [];


    public function supervisor()
{
    return $this->belongsTo(User::class, 'supervisor_id');
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(AdministrativeUnit::class, 'program_id');
    }


public function attachmentStudent()
{
    return $this->hasOne(AttachmentStudent::class, 'student_id');
}


}
