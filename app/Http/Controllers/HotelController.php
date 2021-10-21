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
        $hotel = Hotel::with('district');
        $paginate = 10;
        if ($request->has('name')) {
            $hotel->where('name', 'like', "%" . $request->name . "%");
            $hotel->orWhere('address_tag', 'like', "%" . $request->name . "%");
        }

        if ($request->has('district')) {
            $hotel->where('district_id', $request->district);
        }

        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        return HotelResource::collection($hotel->paginate($paginate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'address_tag' => 'required',
            'district_id' => 'required|numeric',
            'photos' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $stored = Hotel::create($request->all());

        return response()->json([
            'message' => 'New hotel has been created.',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::with('district')->findOrFail($id);
        return new HotelResource($hotel);
    }

    /**
     * Edit the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json([
            'data' => $hotel
        ], 200);
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
