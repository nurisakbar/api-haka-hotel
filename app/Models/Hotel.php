<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\HotelFacility;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'address_tag',
        'regency_id',
        'photos'
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function hotelFacility()
    {
        return $this->hasMany(HotelFacility::class);
    }

    public function getAddressTagAttribute($value)
    {
        return explode(',', $value);
    }

    public function getPhotosAttribute($value)
    {
        return collect(unserialize($value))->map(function ($photo) {
            return url('/storage/images/hotel/' . $photo);
        });
    }
}
