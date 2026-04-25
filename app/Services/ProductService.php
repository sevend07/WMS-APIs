<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct($product, $data)
    {
        return $product->update($data);
    }

    public function archiveProduct()
    {
        
    }

    public function getNeedRestockProduct()
    {

    }

    public function generateSKU()
    {
        
    }
}
