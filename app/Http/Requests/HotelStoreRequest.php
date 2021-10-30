<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelStoreRequest extends FormRequest
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
            'name'        => 'required',
            'address'     => 'required',
            'address_tag' => 'required',
            'regency_id'  => 'required|numeric|exists:regencies,id',
            'photos'      => 'required|mimes:jpg,png'
        ];
    }
}
