<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['admin', 'cliente'];
        $rol = $this->faker->randomElement($roles);
        // Generate a realistic username from name
        $nombre = $this->faker->name;
        $username = strtolower(str_replace(' ', '.', $nombre));
        // Ensure email is unique (Faker handles unique)
        $email = $this->faker->unique()->safeEmail();

        return [
            'nombre_usuario' => $nombre,
            'email_usuario' => $email,
            'contrasena_usuario' => Hash::make('password'), // default password
            'rol_usuario' => $rol,
            'activo_usuario' => $this->faker->boolean(90), // 90% active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
