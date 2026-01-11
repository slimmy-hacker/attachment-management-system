<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(AdministrativeUnit::class, 'department_id');
    }
    public function jobGrade()
{
    return $this->belongsTo(JobGrade::class);
}

public function budgets()
{
    return $this->hasMany(Budget::class);
}

}
