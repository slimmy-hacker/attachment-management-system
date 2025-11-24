<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    public function county()
    {
        return $this->belongsTo(Location::class, 'county_id');
    }

    public function subcounty()
    {
        return $this->belongsTo(Location::class, 'sub_county_id');
    }
    public function opportunities()
{
    return $this->hasMany(Opportunity::class);
}

}
