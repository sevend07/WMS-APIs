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
        $perPage = $request->integer('per_page', 15);
        $filters = $request->only(['status', 'has_supplier']);

        $products = $request->filled('search')
            ? Product::search($request->search)
            ->query(fn($query) => $query->withCount('suppliers')->filter($filters))
            ->paginate($perPage)
            : Product::withCount('suppliers')
            ->filter($filters)
            ->paginate($perPage);

        return ProductResource::collection($products);
        // $products = $request->filled('search')
        //     ? Product::search($request->search)
        //     ->query(fn($query) => $query->withCount('suppliers')->filter($filters))
        //     ->paginate($perPage)
        //     : Product::withCount('suppliers')
        //     ->filter($filters)
        //     ->paginate($perPage);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);

        return response([
            'Message' => 'Created',
            'Products' => new ProductResource($product)
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
}
