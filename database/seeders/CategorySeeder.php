<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'sport'],
            ['name' => 'sneakers'],
            ['name' => 'formal'],
        ];

        foreach ($categories as $category) {
            // Menggunakan updateOrCreate agar jika seeder dijalankan ulang, 
            // tidak terjadi error duplicate entry.
            Category::updateOrCreate(
                ['name' => $category['name']], 
                $category
            );
        }
    }
}
