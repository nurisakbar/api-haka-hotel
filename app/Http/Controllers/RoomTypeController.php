<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Http\Resources\RoomTypeResource;
use App\Http\Requests\RoomTypeStoreRequest;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $idHotel = null)
    {
        $perPage = 10;
        $roomType = RoomType::with('hotel');

        if ($request->has('type') == 'datatables') {
            return \DataTables::of($roomType->where('hotel_id', $idHotel)->get())
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn btn-primary btn-sm" href="/hotel/' . $data->hotel_id . '/roomtype/' . $data->id . '/edit"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-success btn-sm mx-1" href="/hotel/' . $data->hotel_id . '/roomtype/' . $data->id . '"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/hotel/' . $data->hotel_id . '/roomtype/' . $data->id . '/delete"><i class="fas fa-trash" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->addColumn('price', function ($data) {
                    return 'Rp. ' . number_format($data->price);
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
            'message' => 'all data room type',
            'data'    => RoomTypeResource::collection($roomType->paginate($perPage))
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomTypeStoreRequest $request)
    {
        $images = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('public/images/hotel/room-type', $name);
                array_push($images, $name);
            }
        }
        $request['images']  = serialize($images);
        $roomType           = RoomType::create($request->all());

        $response           = [
            'success'   =>  true,
            'message'   =>  'a new room type has added',
            'data'      =>  new RoomTypeResource($roomType)
        ];

        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idHotel, $idRoom)
    {
        $roomType = RoomType::with('hotel')->where('id', $idRoom)->where('hotel_id', $idHotel)->first();

        $response = [
            'success'   =>  true,
            'message'   => 'room type data',
            'data'      =>  new RoomTypeResource($roomType)
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
    public function update(RoomTypeStoreRequest $request, $idHotel, $idRoom)
    {
        // Update room type
        RoomType::where('id', $idRoom)->where('hotel_id', $idHotel)->update($request->all());
        // Get room type after updated
        $roomType = RoomType::where('id', $idRoom)->first();
        $response = [
            'success' => true,
            'message' => 'Room type has been updated.',
            'data'    => new RoomTypeResource($roomType)
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idHotel, $idRoom)
    {
        $roomType = RoomType::where('id', $idRoom)->where('hotel_id', $idHotel)->first();
        $response = [
            'success' => true,
            'message' => 'Room type has been deleted.',
            'data' => new RoomTypeResource($roomType)
        ];
        $roomType->delete();

        return response()->json($response, 200);
    }
}
