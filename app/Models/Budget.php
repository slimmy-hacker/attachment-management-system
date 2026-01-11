<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
  
    protected $fillable = [
        'lecturer_id',
        'students_count',
        'days',
        'transport'
    ];
    public function lecturer()
{
    return $this->belongsTo(Lecturer::class);
}

}
