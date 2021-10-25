<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BannerStoreRequest;

class BannerController extends Controller
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

        $response = [
            'success' => true,
            'message' => 'all data banner',
            'data'    => BannerResource::collection(Banner::paginate($perPage))
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerStoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $filnameWithext = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filnameWithext, PATHINFO_FILENAME);
            $extension = $request->file('image')->extension();
            $fileNameSimpan = $filename . '_' . time() . ".$extension";
            $path = $request->file('image')->storeAs('public/images', $fileNameSimpan);
        }

        $banner = Banner::create([
            'name' => $request->name,
            'image' => $path,
            'publish' => 0,
            'description' => $request->description
        ]);

        $response = [
            'success' => true,
            'message' => 'a new banner has been added.',
            'data'    => new BannerResource($banner)
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
        $banner = Banner::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'data banner',
            'data'    => new BannerResource($banner)
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
        // Update banner
        Banner::findOrFail($id)->update($request->all());
        // Get banner after updated
        $banner = Banner::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Banner has been updated',
            'data'    => new BannerResource($banner)
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
        $banner = Banner::findOrFail($id);
        Storage::delete($banner->image);

        $response = [
            'success' => true,
            'message' => 'Banner has been deleted',
            'data' => new BannerResource($banner)
        ];
        $banner->delete();

        return response()->json($response, 200);
    }
}
