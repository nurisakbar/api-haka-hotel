<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Http\Resources\HotelResource;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $hotel = Hotel::with('regency');
        if ($request->has('name')) {
            $hotel->where('name', 'like', "%" . $request->name . "%");
            $hotel->orWhere('address_tag', 'like', "%" . $request->name . "%");
        }

        if ($request->has('regency')) {
            $hotel->where('regency_id', $request->regency);
        }

        if ($request->has('paginate')) {
            $perPage = $request->paginate;
        }
        return HotelResource::collection($hotel->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelStoreRequest $request)
    {
        $photos = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $fileName = str_replace(' ', '', $file->getClientOriginalName());
                $path = $file->storeAs('public/images/hotel', $fileName);
                $photos[] = $fileName;
            }
        }
        $request['photos']  = serialize($photos);
        $hotel              = Hotel::create($request->all());

        $response           = [
            'success'   =>  true,
            'message'   =>  'a new hotel has added',
            'data'      =>  new HotelResource($hotel)
        ];
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::with('regency', 'hotelFacility.facility')->findOrFail($id);
        $response = [
            'success'   =>  true,
            'message'   => 'hotel data',
            'data'      =>  new HotelResource($hotel)
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'address'     => 'required',
            'address_tag' => 'required',
            'district_id' => 'required|numeric',
            'photos'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        Hotel::findOrFail($id)->update($request->all());

        return response()->json([
            'message' => 'Hotel has been updated.',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json(['message' => 'Delete Success', 'success' => true], 200);
    }
}
