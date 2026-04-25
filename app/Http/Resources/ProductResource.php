<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'unit' => $this->unit,
            'min_stock' => $this->min_stock,
            'status' => $this->stock_status,
            'has_supplier' => $this->suppliers_count > 0,
            'suppliers' => SupplierResource::collection(
                $this->whenLoaded('suppliers')
            ),
            'created_at' => $this->created_at,
            
            'updated_at' => $this->updated_at,
        ];
    }
}
