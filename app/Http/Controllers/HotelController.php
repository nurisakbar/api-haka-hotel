<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelStoreRequest;
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
        $perPage = 10;
        $hotel = Hotel::with('regency');
        if ($request->has('name')) {
            $hotel->where('name', 'like', "%" . $request->name . "%");
            $hotel->orWhere('address_tag', 'like', "%" . $request->name . "%");
        }

        if ($request->has('regency')) {
            $hotel->where('regency_id', $request->regency);
        }

        if ($request->has('type') == 'datatables') {
            return \DataTables::of($hotel->get())
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn btn-primary btn-sm" href="/hotel/' . $data->id . '/edit"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-success btn-sm mx-1" href="/hotel/' . $data->id . '"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/hotel/' . $data->id . '/delete"><i class="fas fa-trash" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('paginate')) {
            $perPage = $request->paginate;
        }


        $response = [
            'success' => true,
            'message' => 'all data hotel',
            'data'    => HotelResource::collection($hotel->paginate($perPage))
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photos = [];
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            foreach ($files as $file) {
                $fileName = str_replace(' ', '', $file->getClientOriginalName());
                $path = $file->storeAs('public/images/hotel', $fileName);
                array_push($photos, $fileName);
            }
            $request['photos']  = serialize($photos);
        }
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
    public function update(HotelStoreRequest $request, $id)
    {
        // Update hotel
        Hotel::findOrFail($id)->update($request->all());
        // Get hotel after updated
        $hotel = Hotel::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Hotel has been updated.',
            'data'    => new HotelResource($hotel)
        ];

        return response()->json($response, 200);
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
        $response = [
            'success' => true,
            'message' => 'Hotel has been deleted.',
            'data' => new HotelResource($hotel)
        ];
        $hotel->delete();

        return response()->json($response, 200);
    }
}
