<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductManagementService
{
    public function bulkCreateCategory(array $data) 
    {
        return DB::transaction(function () use ($data) {
            $category = Category::fillAndInsert($data);

            return $category;
        });
    }

    public function bulkCreateBrand(array $data) 
    {
        return DB::transaction(function () use ($data) {
            $brand = Brand::fillAndInsert($data);

            return $brand;
        });
    }

    public function createProduct(array $data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'brand_id' => $data['brand_id'],
                'category_id' => $data['category_id']
            ]);
    
            $product->productVariants()->createMany($data['variants']);
    
            return $product->load('productVariants');
        });
    }

    public function updateProduct($product, $data)
    {
        return $product->update($data);
    }

    public function archiveProduct() {}

    public function getNeedRestockProduct() {}

    public function generateSKU() {}
}
