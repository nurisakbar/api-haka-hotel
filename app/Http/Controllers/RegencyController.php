<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regency;

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
            $regency->where('name', 'like', "%".$request->name."%");
        }

        return response()->json($regency->get(), 200);
    }
}
