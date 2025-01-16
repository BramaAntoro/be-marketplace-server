<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::join("product_types", "products.product_type_id", "=", "product_types.id")
        ->select("products.*", "product_types.type_name")
        ->get();
        return response([
            "massage" => "product type list",
            "data" => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // $time = Carbon::now();
        // $doc = str_replace(" ", "-", $time) . '.' . $request->profile_picture->extension();
        // $request->file("profile_picture")->move(public_path("upload/profile"), $doc);

        $imagename = time().'.'.$request->img_url->extension();

        $request->img_url->move(public_path('image'), $imagename);

        Product::create([
            'product_name' => $request->product_name,
            'product_type_id' => $request->product_type_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_url' => url('image/'.$imagename),
            'img_name' => $imagename,

        ]);

        return response(["massage" => "Product  created successfully"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);

        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
                "data" => [],
            ], 404);
        }
        return response([
            "massage" => "product type list",
            "data" => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $data = Product::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
                "data" => [],
            ], 404);
        }
        

        $data->product_name = $request->product_name;
        $data->product_type_id = $request->product_type_id;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->img_url = $request->img_url;
        $data->save();

        return response([
            "massage" => "product type updated",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);

        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
                "data" => [],
            ], 404);
        }

        $data->delete();

        return response([
            "massage" => "product type deleted",
            "data" => $data,
        ]);
    }
}
