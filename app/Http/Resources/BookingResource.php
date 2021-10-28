<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $totalDay = date_diff(date_create($this->start_date), date_create($this->end_date))->format('%a');
        $totalPrice = $totalDay * $this->roomType->price;

        return [
            'id'            =>  $this->id,
            'user'          =>  $this->user->name,
            'room_type'     =>  $this->roomType->name,
            'start_date'    =>  $this->start_date,
            'end_date'      =>  $this->end_date,
            'price'         =>  $this->roomType->price,
            'total'         =>  $totalPrice,
        ];
    }
}
