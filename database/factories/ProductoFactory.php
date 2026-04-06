<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(2, true),
            'precio' => $this->faker->randomFloat(2, 1, 100),
            'descripcion' => $this->faker->sentence(),
            'categoria' => $this->faker->randomElement(["Calzado", "Ropa", "Accesorios", "Perfumería", "Deporte"]),
            'stock' => $this->faker->numberBetween(0, 100),
            'imagen' => $this->faker->imageUrl(640, 480, 'product', true),
            ];
    }
}
