<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::all();
        return response([
            "message" => 'Banner List',
            "data" => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_img' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048', 
        ]);

        $imageName = time() . "." . $request->banner_img->extension();
        $request->banner_img->move(public_path('image'), $imageName);

        Banner::create([
            'banner_img' => url('image/' . $imageName), 
            'banner_name' => $imageName               
        ]);

        return response([
            "message" => "Banner created successfully."
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner not found."
            ], 404);
        }

        return response([
            "message" => "Banner retrieved.",
            "data" => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner_img' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048', 
        ]);

        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner not found."
            ], 404);
        }

        $imageName = time() . "." . $request->banner_img->extension();
        $request->banner_img->move(public_path('image'), $imageName);

        $data->banner_img = url('image/' . $imageName); 
        $data->banner_name = $imageName;               
        $data->save();

        return response([
            "message" => "Banner updated."
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "message" => "Banner not found."
            ], 404);
        }

        $data->delete();
        return response([
            "message" => "Banner deleted."
        ], 200);
    }
}
