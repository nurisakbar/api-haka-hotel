<?php

namespace App\Http\Controllers;

use App\Models\HotelFacility;
use App\Http\Resources\HotelFacilityResource;
use App\Http\Requests\HotelFacilityStoreRequest;

class HotelFacilityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelFacilityStoreRequest $request)
    {
        $hotelFacility = HotelFacility::create($request->all());

        $response = [
            'success'   =>  true,
            'message'   =>  'a new hotel facility has added',
            'data'      =>  new HotelFacilityResource($hotelFacility)
        ];

        return response()->json($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotelFacility = HotelFacility::findOrFail($id);

        $response = [
            'success' => true,
            'message' => 'hotel facility has been deleted',
            'data'    => new HotelFacilityResource($hotelFacility)
        ];

        $hotelFacility->delete();

        return response()->json($response, 200);
    }
}
