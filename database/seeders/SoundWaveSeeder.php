<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SoundWaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. LIMPIAR TABLAS (Para evitar duplicados si lo ejecutas varias veces)
        // Desactivamos llaves foráneas temporalmente para poder vaciar con truncate
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('tbl_cancion_lista')->truncate();
        DB::table('tbl_listas_reproduccion')->truncate();
        DB::table('tbl_canciones')->truncate();
        DB::table('tbl_artistas')->truncate();
        DB::table('tbl_generos')->truncate();
        DB::table('tbl_usuarios')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // 2. INSERTAR USUARIOS DE PRUEBA (Para que tengas con qué probar el login)
        DB::table('tbl_usuarios')->insert([
            [
                'nombre_usuario' => 'Soundwave Admin',
                'email_usuario' => 'admin@soundwave.com',
                'contrasena_usuario' => Hash::make('qazQAZ123'),
                'rol_usuario' => 'admin',
                'activo_usuario' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_usuario' => 'Cliente',
                'email_usuario' => 'cliente@soundwave.com',
                'contrasena_usuario' => Hash::make('qazQAZ123'),
                'rol_usuario' => 'cliente',
                'activo_usuario' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_usuario' => 'hugo',
                'email_usuario' => 'hugo@soundwave.com',
                'contrasena_usuario' => Hash::make('qazQAZ123'),
                'rol_usuario' => 'cliente',
                'activo_usuario' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 3. INSERTAR GÉNEROS Y GUARDAR SUS IDS
        $generos = [
            'Funk/Pop' => DB::table('tbl_generos')->insertGetId(['nombre_genero' => 'Funk/Pop', 'created_at' => now(), 'updated_at' => now()]),
            'Indie Rock' => DB::table('tbl_generos')->insertGetId(['nombre_genero' => 'Indie Rock', 'created_at' => now(), 'updated_at' => now()]),
            'Dream Pop' => DB::table('tbl_generos')->insertGetId(['nombre_genero' => 'Dream Pop', 'created_at' => now(), 'updated_at' => now()]),
            'Ambient/OST' => DB::table('tbl_generos')->insertGetId(['nombre_genero' => 'Ambient/OST', 'created_at' => now(), 'updated_at' => now()]),
        ];

        // 4. INSERTAR ARTISTAS Y GUARDAR SUS IDS
        $artistas = [
            'Jamiroquai' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'Jamiroquai', 'created_at' => now(), 'updated_at' => now()]),
            'Tame Impala' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'Tame Impala', 'created_at' => now(), 'updated_at' => now()]),
            'Her\'s' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'Her\'s', 'created_at' => now(), 'updated_at' => now()]),
            'TV Girl' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'TV Girl', 'created_at' => now(), 'updated_at' => now()]),
            'kensuke ushio' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'kensuke ushio', 'created_at' => now(), 'updated_at' => now()]),
            'Mac DeMarco' => DB::table('tbl_artistas')->insertGetId(['nombre_artista' => 'Mac DeMarco', 'created_at' => now(), 'updated_at' => now()]),
        ];

        // 5. INSERTAR TU LISTA DE CANCIONES ESPECÍFICA
        // Tiempos reales aproximados en segundos, rutas simuladas en 'storage/portadas/' y 'storage/audio/'
        DB::table('tbl_canciones')->insert([
            // Jamiroquai
            [
                'titulo_cancion' => 'Virtual insanity',
                'duracion_cancion' => 340, 
                'id_artista_fk' => $artistas['Jamiroquai'],
                'id_genero_fk' => $generos['Funk/Pop'],
                'ruta_portada_cancion' => 'storage/portadas/virtual_insanity.jpg',
                'ruta_audio_cancion' => 'storage/audio/virtual_insanity.mp3',
            ],
            [
                'titulo_cancion' => 'Cosmic Girl',
                'duracion_cancion' => 243,
                'id_artista_fk' => $artistas['Jamiroquai'],
                'id_genero_fk' => $generos['Funk/Pop'],
                'ruta_portada_cancion' => 'storage/portadas/cosmic_girl.jpg',
                'ruta_audio_cancion' => 'storage/audio/cosmic_girl.mp3',
            ],
            // Tame Impala
            [
                'titulo_cancion' => 'Borderline',
                'duracion_cancion' => 237,
                'id_artista_fk' => $artistas['Tame Impala'],
                'id_genero_fk' => $generos['Indie Rock'],
                'ruta_portada_cancion' => 'storage/portadas/borderline.jpg',
                'ruta_audio_cancion' => 'storage/audio/borderline.mp3',
            ],
            [
                'titulo_cancion' => 'The less I know the better',
                'duracion_cancion' => 216,
                'id_artista_fk' => $artistas['Tame Impala'],
                'id_genero_fk' => $generos['Indie Rock'],
                'ruta_portada_cancion' => 'storage/portadas/the_less_i_know_the_better.jpg',
                'ruta_audio_cancion' => 'storage/audio/the_less_i_know_the_better.mp3',
            ],
            // Her's
            [
                'titulo_cancion' => 'Harvey',
                'duracion_cancion' => 213,
                'id_artista_fk' => $artistas['Her\'s'],
                'id_genero_fk' => $generos['Dream Pop'],
                'ruta_portada_cancion' => 'storage/portadas/harvey.jpg',
                'ruta_audio_cancion' => 'storage/audio/harvey.mp3',
            ],
            [
                'titulo_cancion' => 'What Once Was',
                'duracion_cancion' => 255,
                'id_artista_fk' => $artistas['Her\'s'],
                'id_genero_fk' => $generos['Dream Pop'],
                'ruta_portada_cancion' => 'storage/portadas/what_once_was.jpg',
                'ruta_audio_cancion' => 'storage/audio/what_once_was.mp3',
            ],
            // TV Girl
            [
                'titulo_cancion' => 'The Blonde',
                'duracion_cancion' => 224,
                'id_artista_fk' => $artistas['TV Girl'],
                'id_genero_fk' => $generos['Dream Pop'],
                'ruta_portada_cancion' => 'storage/portadas/the_blonde.jpg',
                'ruta_audio_cancion' => 'storage/audio/the_blonde.mp3',
            ],
            [
                'titulo_cancion' => 'Lover\'s Rock',
                'duracion_cancion' => 213,
                'id_artista_fk' => $artistas['TV Girl'],
                'id_genero_fk' => $generos['Dream Pop'],
                'ruta_portada_cancion' => 'storage/portadas/lovers_rock.jpg',
                'ruta_audio_cancion' => 'storage/audio/lovers_rock.mp3',
            ],
            // kensuke ushio
            [
                'titulo_cancion' => 'In the pool',
                'duracion_cancion' => 252,
                'id_artista_fk' => $artistas['kensuke ushio'],
                'id_genero_fk' => $generos['Ambient/OST'],
                'ruta_portada_cancion' => 'storage/portadas/in_the_pool.jpg',
                'ruta_audio_cancion' => 'storage/audio/in_the_pool.mp3',
            ],
            [
                'titulo_cancion' => 'slow summer eve',
                'duracion_cancion' => 186,
                'id_artista_fk' => $artistas['kensuke ushio'],
                'id_genero_fk' => $generos['Ambient/OST'],
                'ruta_portada_cancion' => 'storage/portadas/slow_summer_eve.jpg',
                'ruta_audio_cancion' => 'storage/audio/slow_summer_eve.mp3',
            ],
            // Mac DeMarco
            [
                'titulo_cancion' => 'My Kind of Woman',
                'duracion_cancion' => 190,
                'id_artista_fk' => $artistas['Mac DeMarco'],
                'id_genero_fk' => $generos['Indie Rock'],
                'ruta_portada_cancion' => 'storage/portadas/my_kind_of_woman.jpg',
                'ruta_audio_cancion' => 'storage/audio/my_kind_of_woman.mp3',
            ],
            [
                'titulo_cancion' => 'Freaking Out the Neighborhood',
                'duracion_cancion' => 173,
                'id_artista_fk' => $artistas['Mac DeMarco'],
                'id_genero_fk' => $generos['Indie Rock'],
                'ruta_portada_cancion' => 'storage/portadas/freaking_out_the_neighborhood.jpg',
                'ruta_audio_cancion' => 'storage/audio/freaking_out_the_neighborhood.mp3',
            ],
        ]);
    }
}
