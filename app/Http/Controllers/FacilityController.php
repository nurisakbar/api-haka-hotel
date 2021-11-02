<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Resources\FacilityResource;
use App\Http\Requests\FacilityStoreRequest;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;

        if ($request->has('paginate')) {
            $perPage = $request->paginate;
        }

        $facilites = Facility::paginate($perPage);

        if ($request->has('type') == 'datatables') {
            return \DataTables::of(Facility::all())
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn btn-primary btn-sm" href="/facilities/' . $data->id . '/edit"><i class="fas fa-edit" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-success btn-sm mx-1" href="/facilities/' . $data->id . '"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/facilities/' . $data->id . '/delete"><i class="fas fa-trash" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        $response = [
            'success' => true,
            'message' => 'all data facility',
            'data'    => FacilityResource::collection($facilites)
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacilityStoreRequest $request)
    {
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = str_replace(' ', '', $file->getClientOriginalName());
            $path = $file->storeAs('public/images/facility', $fileName);
        }

        $request['image'] = $fileName;
        $facility        = Facility::create($request->all());

        $response           = [
            'success'   =>  true,
            'message'   =>  'a new facility has added',
            'data'      =>  new FacilityResource($facility)
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
        $facility = Facility::findOrFail($id);
        $response = [
            'success'   =>  true,
            'message'   => 'hotel data',
            'data'      =>  new FacilityResource($facility)
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
    public function update(FacilityStoreRequest $request, $id)
    {
        // Update facility
        Facility::findOrFail($id)->update($request->all());
        // Get facility after updated
        $facility = Facility::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Facility has been updated.',
            'data'    => new FacilityResource($facility)
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
        $facility = Facility::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Facility has been deleted.',
            'data' => new FacilityResource($facility)
        ];
        $facility->delete();

        return response()->json($response, 200);
    }
}
