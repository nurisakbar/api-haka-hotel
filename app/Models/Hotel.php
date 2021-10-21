<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'address_tag', 'district_id', 'photos'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
