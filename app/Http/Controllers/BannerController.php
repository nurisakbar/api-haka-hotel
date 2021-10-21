<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = 10;

        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        return BannerResource::collection(Banner::paginate($paginate));
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
            'name'        => 'required',
            'image'       => 'required',
            'publish'     => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $stored = Banner::create([
            'name' => $request->name,
            'image' => '',
            'publish' => 0,
            'description' => $request->description
        ]);

        if ($request->hasFile('image')) {
            $path = Storage::disk('local')->put($request->file('image')->getClientOriginalName(), $request->file('image')->get());
            $path = $request->file('image')->store('images/');
            Banner::findOrFail($stored->id)->update(['image' => $path]);
        }

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
     * edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return response()->json([
            'data' => $banner
        ]);
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
            'image'       => 'required',
            'publish'     => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

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
        $banner->delete();
        return response()->json(['message' => 'Delete Success', 'success' => true], 200);
    }
}
