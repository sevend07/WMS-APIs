<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $names = [
        //     'Baja Ringan C75', 'Baja Ringan Reng', 'Besi Hollow Galvanis', 'Besi Hollow Hitam', 'Besi Beton Polos',
        //     'Besi Beton Ulir', 'Besi Siku', 'Besi UNP (Kanal U)', 'Besi CNP (Kanal C)', 'Besi WF (Wide Flange)',
        //     'Besi H-Beam', 'Plat Besi Hitam', 'Plat Bordes', 'Plat Strip', 'Plat Galvanis',
        //     'Pipa Besi Hitam', 'Pipa Galvanis', 'Pipa Seamless', 'Kawat Bendrat', 'Wiremesh',
        //     'Expanded Metal', 'Grating Baja', 'Dynabolt', 'Baut dan Mur Baja', 'Sekrup SDS',
        //     'Angkur Baja', 'Talang Galvalum', 'Spandek', 'Atap Galvalum', 'Atap Zincalume',
        // ];

        $units = [
            'batang', 'lembar', 'roll'
        ];

        // $name = fake()->randomElement($names);
        $unit = fake()->randomElement($units);

        return [
            'sku' => null,
            'name' => $this->faker->words(3, true),
            'unit' => $unit,
            'stock' => fake()->numberBetween(0, 10000),
            'min_stock' => fake()->numberBetween(5, 100),
        ];
    }

    public function available(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => fake()->numberBetween(101, 10000),
            ];
        });

    }

    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $min_stock = $attributes['min_stock'];

            return [
                'stock' => fake()->numberBetween(5, $min_stock),
            ];
        });

    }

    public function empty(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });

    }
}
