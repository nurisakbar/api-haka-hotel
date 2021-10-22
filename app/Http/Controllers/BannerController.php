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
        return BannerResource::collection(Banner::paginate($perPage));
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

        $stored = Banner::create([
            'name' => $request->name,
            'image' => $path,
            'publish' => 0,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Banner has been created',
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
        $banner = Banner::findOrFail($id);
        return new BannerResource($banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerStoreRequest $request, $id)
    {
        Banner::findOrFail($id)->update($request->all());

        return response()->json([
            'message' => 'Banner has been updated',
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
        $banner = Banner::findOrFail($id);
        Storage::delete($banner->image);
        $banner->delete();

        return response()->json(['message' => 'Delete Success', 'success' => true], 200);
    }
}
