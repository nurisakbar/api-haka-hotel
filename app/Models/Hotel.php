<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\HotelFacility;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'address_tag', 'district_id', 'photos'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function hotelFacility()
    {
        return $this->hasMany(HotelFacility::class);
    }
}
