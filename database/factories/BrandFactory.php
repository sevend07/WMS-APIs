<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Daftar sepatu branded untuk hasil yang lebih realistis
        $brands = ['Nike', 'Adidas', 'New Balance', 'Puma', 'Reebok', 'Vans', 'Converse'];

        return [
            // unique() memastikan tidak ada nama yang sama terpilih dua kali
            'name' => $this->faker->unique()->randomElement($brands),
        ];
    }
}
