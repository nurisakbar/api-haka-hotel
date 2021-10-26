<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->images) {
            $images = collect(unserialize($this->images))->map(function ($photo) {
                return url('/storage/images/hotel/room-type' . $photo);
            });
        } else {
            $images = [];
        }


        return [
            'id'            =>  $this->id,
            'hotel'         =>  $this->hotel->name,
            'name'          =>  $this->name,
            'price'         =>  $this->price,
            'description'   =>  $this->description,
            'images'        =>  $images,
        ];
    }
}
