<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    public function county()
    {
        return $this->belongsTo(Location::class, 'county');
    }

    public function subcounty()
    {
        return $this->belongsTo(Location::class, 'subcounty');
    }
}
