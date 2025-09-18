<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship: Each logbook belongs to a student (via registration_number)
    public function student()
    {
        return $this->belongsTo(User::class, 'registration_number', 'registration_number');
    }
}
