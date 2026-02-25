<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query()->withCount('suppliers');

        if ($request->filled('search')) {
            $query->search($request->search);
        };

        if ($request->filled('status')) {
            match ($request->status) {
                'available' => $query->available(),
                'low' => $query->lowStock(),
                'empty' => $query->outOfStock(),
                default => null
            };
        };

        if ($request->filled('has_supplier')) {
            match ($request->has_supplier) {
                'true' => $query->hasSupplier(),
                'false' => $query->withOutSupplier(),
                default => null
            };
        };

        $products = $query->paginate($request->get('per_page', 15));

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);

        return response([
            'message' => 'Created',
            'P' => new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response([
            'Message' => 'Updated',
            'data' => new ProductResource($product)
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
}
