<?php

namespace Database\Factories;

use App\Models\Artista;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Artista>
 */
class ArtistaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->unique()->name;
        // Sometimes add "Featuring" or "Band" to make it more varied
        if ($this->faker->boolean(30)) {
            $nombre .= ' & ' . $this->faker->name;
        } elseif ($this->faker->boolean(20)) {
            $nombre .= ' Featuring ' . $this->faker->name;
        }

        return [
            'nombre_artista' => $nombre,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
