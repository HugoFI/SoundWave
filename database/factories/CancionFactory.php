<?php

namespace Database\Factories;

use App\Models\Cancion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Cancion>
 */
class CancionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = $this->faker->sentence(3);
        // Remove trailing period
        $titulo = rtrim($titulo, '.');
        $duracion = $this->faker->numberBetween(120, 360); // 2 to 6 minutes
        // For storage paths we'll simulate
        $portada = 'storage/portadas/' . Str::slug($titulo) . '.jpg';
        $audio = 'storage/audio/' . Str::slug($titulo) . '.mp3';

        return [
            'titulo_cancion' => $titulo,
            'duracion_cancion' => $duracion,
            'ruta_portada_cancion' => $portada,
            'ruta_audio_cancion' => $audio,
            // Foreign keys will be set when we define relationships
            'id_artista_fk' => null,
            'id_genero_fk' => null,
        ];
    }
}
