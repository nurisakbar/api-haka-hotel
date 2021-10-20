<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Http\Resources\HotelResource;

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
            $hotel->where('name', 'like', "%".$request->name."%");
            $hotel->orWhere('address_tag', 'like', "%".$request->name."%");
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
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        return response()->json(['message'=>'Delete Success','success'=>true], 200);
    }
}
