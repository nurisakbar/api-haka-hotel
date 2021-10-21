<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\HotelFacility;

class Hotel extends Model
{
    use HasFactory;

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function hotelFacility()
    {
        return $this->hasMany(HotelFacility::class);
    }
}
