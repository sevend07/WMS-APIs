<?php

namespace Database\Seeders;

use App\Models\product;
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
        product::factory(2500)->available()->create();

        # Low Prods
        product::factory(1500)->lowStock()->create();

        # Empty Prods
        product::factory(1000)->empty()->create();
    }
}
