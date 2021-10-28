<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $booking = Booking::with(['user', 'roomType']);

        if ($request->has('paginate')) {
            $perPage = $request->paginate;
        }

        if ($request->has('type') == 'datatables') {
            return \DataTables::of($booking->get())
                ->addIndexColumn()
                ->make(true);
        }

        $response = [
            'success' => true,
            'message' => 'all data booking',
            'data'    => BookingResource::collection(Booking::paginate($perPage))
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
        if (!$token = JWTAuth::parseToken()) {
            $response = [
                'success' => false,
                'message' => 'Invalid Token'
            ];
            return response()->json($response, 400);
        }

        $booking = Booking::create($request->all());
        $response = [
            'success' => true,
            'message' => 'new booking has been created.',
            'data'    => new BookingResource($booking)
        ];

        return response()->json($response, 201);
    }
}
