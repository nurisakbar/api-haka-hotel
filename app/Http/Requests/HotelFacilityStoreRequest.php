<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelFacilityStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facility_id' => 'required|exists:facilities,id',
            'hotel_id' => 'required|exists:hotels,id'
        ];
    }
}
