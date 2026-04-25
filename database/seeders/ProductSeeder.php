<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Available Prods
        Product::factory(2500)->available()->create();

        # Low Prods
        Product::factory(1500)->lowStock()->create();

        # Empty Prods
        Product::factory(1000)->empty()->create();
    }
}
