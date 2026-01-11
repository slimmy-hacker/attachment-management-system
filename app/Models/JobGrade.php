<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobGrade extends Model
{
    use HasFactory;

    protected $table = 'job_grades';

    protected $fillable = [
        'public_service_group',
        'dekut_grade',
        'designation',
        'daily_allowance',
        'applies_to',
    ];
}
