<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $table = 'students';

    protected $guarded = [];

    public function placements()
    {
        return $this->hasMany(Placement::class, 'student_id');
    }
    public function supervisor()
{
    return $this->belongsTo(User::class, 'supervisor_id');
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
