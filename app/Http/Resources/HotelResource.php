<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HotelFacilityResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->photos) {
            $photos = collect(unserialize($this->photos))->map(function ($photo) {
                return url('/hotel_photos/' . $photo);
            });
        } else {
            $photos = [];
        }
        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'address'       =>  $this->address,
            'address_tag'   =>  explode(',', $this->address_tag),
            'photos'        =>  $photos,
            'districts'     =>  $this->regency,
            'facility'      => HotelFacilityResource::collection($this->hotelFacility)
        ];
    }
}
