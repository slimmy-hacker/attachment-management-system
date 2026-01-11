<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

        protected $fillable = [
        'name',
        'email',
        'password',
        'role',
            'phone_number',
        'portal',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isIndustry()
    {
        return $this->role === 'industry';
    }

    public function isUniversity()
    {
        return $this->role === 'university';
    }
public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function reports()
    {
        return $this->hasMany(WeeklyReport::class);
    }
    public function placements()
{
    return $this->hasMany(Placement::class, 'company_id');
}
public function assignedStudents()
{
    return $this->hasMany(User::class, 'supervisor_id')
                ->where('role', 'student');
}
public function student()
{
    return $this->hasOne(Student::class, 'user_id');
}

}
