<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ProductManagementService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data'    => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, ProductManagementService $productService)
    {
        // Implementasi penyimpanan kategori menggunakan service
    }

    public function bulkStore(Request $request, ProductManagementService $productManagementService)
    {
        $validated = $request->validate([
            "categories" => "required|array|min:1",
            "categories.*.name" => "required|string|max:20|distinct|unique:categories,name",
        ]);

        $productManagementService->bulkCreateCategory($validated['categories']);

        return response()->json([
            'success' => true,
            'message' => 'Category berhasil dibuat.',
            'data'    => $validated,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
