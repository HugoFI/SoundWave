<?php

namespace Database\Factories;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Genero>
 */
class GeneroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = $this->faker->unique()->randomElement([
            'Pop', 'Rock', 'Hip Hop', 'Rap', 'R&B', 'Soul', 'Jazz', 'Blues', 
            'Country', 'Folk', 'Electronic', 'EDM', 'House', 'Techno', 'Trance',
            'Dubstep', 'Reggae', 'Ska', 'Punk', 'Metal', 'Classical', 'Opera',
            'Latin', 'Salsa', 'Merengue', 'Bachata', 'Reggaeton', 'Tango',
            'Flamenco', 'K-Pop', 'J-Pop', 'Anime Soundtrack', 'Video Game Music',
            'Ambient', 'Chillout', 'Lo-fi', 'Acoustic', 'Instrumental'
        ]);

        return [
            'nombre_genero' => $nombre,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
