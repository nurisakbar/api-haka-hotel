<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'address'       =>  $this->address,
            'address_tag'   =>  explode(',', $this->address_tag),
            'photos'        =>  unserialize($this->photos),
            'districts'     =>  $this->district,
        ];
    }
}
