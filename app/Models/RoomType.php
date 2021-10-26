<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable =  ['hotel_id', 'name', 'price', 'description', 'images'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
