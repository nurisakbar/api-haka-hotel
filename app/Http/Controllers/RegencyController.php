<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;
use App\Http\Resources\RegencyResource;

class RegencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $regency = Regency::with('province');

        if ($request->has('name')) {
            $regency->where('name', 'like', "%" . $request->name . "%");
        }
        $response = [
            'success'   =>  true,
            'message'   => 'regencies data',
            'data'      =>  RegencyResource::collection($regency->paginate(34))
        ];
        return response()->json($response, 200);
    }
}
