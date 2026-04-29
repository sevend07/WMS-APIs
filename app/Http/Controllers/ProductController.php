<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductManagementService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 15);

        $product = Product::paginate($perPage);
        
        return response()->json([
            "data" => $product,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, ProductManagementService $productService)
    {
        try {
            $product = $productService->createProduct($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Product berhasil dibuat.',
                'data'    => $product,
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada database.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'debug'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response([
            'data' => $product->load('productVariants')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response([
            'Message' => 'Updated',
            'Data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response([
            'Message' => 'Deleted',
        ]);
    }

    public function hardDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        $product->forceDelete();

        return response([
            'Message' => 'Product Permanently Deleted'
        ]);
    }
}
