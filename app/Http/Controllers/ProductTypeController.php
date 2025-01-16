<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductType::all();
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
            'type_name' => 'required|unique:product_types,type_name',
        ], [
            'type_name.required' => ' horee is required',
            'type_name.unique' => ' already exists mas brpp',
        ]);

        ProductType::create([
            'type_name' => $request->type_name,
        ]);

        return response(["massage" => "Product type created successfully"], 201);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProductType::find($id);

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
            'type_name' => 'required|unique:product_types,type_name',
        ]);

        if (is_null(ProductType::find($id))) {
            return response([
                "massage" => "Product type not found",
                "data" => [],
            ], 404);
        }

        $data = ProductType::find($id);
        $data->type_name = $request->type_name;
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
        $data = ProductType::find($id);

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
