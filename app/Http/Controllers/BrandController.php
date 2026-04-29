<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Services\ProductManagementService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();

        return response()->json([
            'success' => true,
            'data'    => $brands,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ProductManagementService $productManagementService)
     {
        // Implementasi penyimpanan brand menggunakan service
    }

    public function bulkStore(Request $request, ProductManagementService $productManagementService)
     {
        $validated = $request->validate([
            "brands" => "required|array|min:1",
            "brands.*.name" => "required|string|unique:brands,name|max:255",
        ]);

        $productManagementService->bulkCreateBrand($validated['brands']);

        return response()->json([
            'success' => true,
            'message' => 'Brand berhasil dibuat.',
            'data'    => $validated,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
