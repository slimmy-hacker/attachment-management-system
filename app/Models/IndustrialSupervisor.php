<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustrialSupervisor extends Model
{
    protected $table = 'industrial_supervisors';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
