<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Genero;
use App\Models\Artista;
use App\Models\Cancion;
use App\Models\Usuario;
use App\Models\ListaReproduccion;

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

        // 2. CREAR USUARIOS ESPECÍFICOS (con credenciales conocidas para pruebas)
        $usuariosEspecificos = Usuario::factory()->create([
            'nombre_usuario' => 'Soundwave Admin',
            'email_usuario' => 'admin@soundwave.com',
            'contrasena_usuario' => Hash::make('qazQAZ123'),
            'rol_usuario' => 'admin',
            'activo_usuario' => true,
        ]);

        Usuario::factory()->create([
            'nombre_usuario' => 'Cliente',
            'email_usuario' => 'cliente@soundwave.com',
            'contrasena_usuario' => Hash::make('qazQAZ123'),
            'rol_usuario' => 'cliente',
            'activo_usuario' => true,
        ]);

        Usuario::factory()->create([
            'nombre_usuario' => 'hugo',
            'email_usuario' => 'hugo@soundwave.com',
            'contrasena_usuario' => Hash::make('qazQAZ123'),
            'rol_usuario' => 'cliente',
            'activo_usuario' => true,
        ]);

        // 3. CREAR GÉNEROS (manteniendo los originales y ampliando con estilos similares)
        $generosData = [
            // Los originales que ya tenías
            ['nombre_genero' => 'Funk/Pop'],
            ['nombre_genero' => 'Indie Rock'],
            ['nombre_genero' => 'Dream Pop'],
            ['nombre_genero' => 'Ambient/OST'],
            
            // Géneros similares/relacionados para expandir de forma coherente
            ['nombre_genero' => 'Neo Soul'],
            ['nombre_genero' => 'Chillwave'],
            ['nombre_genero' => 'Alternative R&B'],
            ['nombre_genero' => 'Psych Pop'],
            ['nombre_genero' => 'Synthpop'],
            ['nombre_genero' => 'Lo-fi Hip Hop'],
            ['nombre_genero' => 'Bedroom Pop'],
            ['nombre_genero' => 'Indie Electronic'],
            ['nombre_genero' => 'Future Funk'],
            ['nombre_genero' => 'City Pop'],
            ['nombre_genero' => 'Vaporwave'],
            ['nombre_genero' => 'Jazz Rap'],
            ['nombre_genero' => 'Nu-disco'],
            ['nombre_genero' => 'Electro Soul'],
            ['nombre_genero' => 'Indie Folk'],
            ['nombre_genero' => 'Alternative Dance'],
            ['nombre_genero' => 'Baroque Pop'],
            ['nombre_genero' => 'Post-punk'],
            ['nombre_genero' => 'Shoegaze']
        ];

        $generosCreados = [];
        foreach ($generosData as $generoDatum) {
            $generosCreados[] = Genero::create($generoDatum);
        }

        // 4. CREAR ARTISTAS CON SUS CANCIONES REALES (enfoque curado, no aleatorio)
        $artistasConCanciones = [
            // Tus artistas originales (manteniendo las canciones específicas)
            [
                'nombre_artista' => 'Jamiroquai',
                'genero' => 'Funk/Pop',
                'canciones' => [
                    ['titulo' => 'Virtual insanity', 'duracion' => 340],
                    ['titulo' => 'Cosmic Girl', 'duracion' => 243],
                    ['titulo' => 'Love Foolosophy', 'duracion' => 278],
                    ['titulo' => 'Canned Heat', 'duracion' => 224],
                    ['titulo' => 'Deeper Underground', 'duracion' => 299],
                    ['titulo' => 'King for a Day', 'duracion' => 228],
                    ['titulo' => 'Supersonic', 'duracion' => 226],
                    ['titulo' => 'Stillness in Time', 'duracion' => 262],
                ]
            ],
            [
                'nombre_artista' => 'Tame Impala',
                'genero' => 'Indie Rock',
                'canciones' => [
                    ['titulo' => 'Borderline', 'duracion' => 237],
                    ['titulo' => 'The less I know the better', 'duracion' => 216],
                    ['titulo' => 'Let It Happen', 'duracion' => 474],
                    ['titulo' => 'Eventually', 'duracion' => 153],
                    ['titulo' => 'Patience', 'duracion' => 306],
                    ['titulo' => 'Lost in Yesterday', 'duracion' => 211],
                    ['titulo' => 'Breathe Deeper', 'duracion' => 309],
                    ['titulo' => 'Is It True', 'duracion' => 270],
                ]
            ],
            [
                'nombre_artista' => 'Her\'s',
                'genero' => 'Dream Pop',
                'canciones' => [
                    ['titulo' => 'Harvey', 'duracion' => 213],
                    ['titulo' => 'What Once Was', 'duracion' => 255],
                    ['titulo' => 'She', 'duracion' => 177],
                    ['titulo' => 'Rosa', 'duracion' => 174],
                    ['titulo' => 'I Can\'t Seem To Make You Mine', 'duracion' => 187],
                    ['titulo' => 'Fast Track', 'duracion' => 163],
                ]
            ],
            [
                'nombre_artista' => 'TV Girl',
                'genero' => 'Dream Pop',
                'canciones' => [
                    ['titulo' => 'The Blonde', 'duracion' => 224],
                    ['titulo' => 'Lover\'s Rock', 'duracion' => 213],
                    ['titulo' => 'Not Allowed', 'duracion' => 152],
                    ['titulo' => 'Taking What\'s Not Yours', 'duracion' => 214],
                    ['titulo' => 'He\'d Have to Be', 'duracion' => 213],
                    ['titulo' => 'Birds Don\'t Sing', 'duracion' => 221],
                ]
            ],
            [
                'nombre_artista' => 'Kensuke Ushio',
                'genero' => 'Ambient/OST',
                'canciones' => [
                    ['titulo' => 'In the pool', 'duracion' => 252],
                    ['titulo' => 'slow summer eve', 'duracion' => 186],
                    ['titulo' => 'Mothlight', 'duracion' => 155],
                    ['titulo' => 'March of the Dead', 'duracion' => 147],
                    ['titulo' => 'Kanata', 'duracion' => 140],
                    ['titulo' => 'The Meaning of a Trial', 'duracion' => 258],
                ]
            ],
            [
                'nombre_artista' => 'Mac DeMarco',
                'genero' => 'Indie Rock',
                'canciones' => [
                    ['titulo' => 'My Kind of Woman', 'duracion' => 190],
                    ['titulo' => 'Freaking Out the Neighborhood', 'duracion' => 173],
                    ['titulo' => 'Chamber of Reflection', 'duracion' => 171],
                    ['titulo' => 'Ode to Viceroy', 'duracion' => 239],
                    ['titulo' => 'Salad Days', 'duracion' => 155],
                    ['titulo' => 'Let My Baby Stay', 'duracion' => 205],
                ]
            ],
            
            // Nuevos artistas que encajan en la estética (indie, soul, electronic, chill)
            [
                'nombre_artista' => 'Phoebe Bridgers',
                'genero' => 'Indie Folk',
                'canciones' => [
                    ['titulo' => 'Motion Sickness', 'duracion' => 253],
                    ['titulo' => 'Kyoto', 'duracion' => 185],
                    ['titulo' => 'Garden Song', 'duracion' => 185],
                    ['titulo' => 'I Know the End', 'duracion' => 312],
                ]
            ],
            [
                'nombre_artista' => 'Clairo',
                'genero' => 'Bedroom Pop',
                'canciones' => [
                    ['titulo' => 'Bags', 'duracion' => 195],
                    ['titulo' => 'Sofia', 'duracion' => 209],
                    ['titulo' => 'Pretty Girl', 'duracion' => 207],
                    ['titulo' => 'Alewife', 'duracion' => 203],
                ]
            ],
            [
                'nombre_artista' => 'Men I Trust',
                'genero' => 'Indie Pop',
                'canciones' => [
                    ['titulo' => 'Show Me How', 'duracion' => 213],
                    ['titulo' => 'Tailwhip', 'duracion' => 216],
                    ['titulo' => 'Oncle Jazz', 'duracion' => 238],
                    ['titulo' => 'Numb', 'duracion' => 220],
                ]
            ],
            [
                'nombre_artista' => 'Rex Orange County',
                'genero' => 'Indie Pop',
                'canciones' => [
                    ['titulo' => 'Loving Is Easy', 'duracion' => 173],
                    ['titulo' => 'Sunflower', 'duracion' => 181],
                    ['titulo' => 'Best Friend', 'duracion' => 202],
                    ['titulo' => 'Pluto Projector', 'duracion' => 207],
                ]
            ],
            [
                'nombre_artista' => 'Steve Lacy',
                'genero' => 'Alternative R&B',
                'canciones' => [
                    ['titulo' => 'Bad Habit', 'duracion' => 172],
                    ['titulo' => 'Dark Red', 'duracion' => 130],
                    ['titulo' => 'Princess Lover', 'duracion' => 165],
                    ['titulo' => 'Mercury', 'duracion' => 206],
                ]
            ],
            [
                'nombre_artista' => 'The Internet',
                'genero' => 'Neo Soul',
                'canciones' => [
                    ['titulo' => 'Come Together', 'duracion' => 242],
                    ['titulo' => 'Girl', 'duracion' => 308],
                    ['titulo' => 'Hold On', 'duracion' => 221],
                    ['titulo' => 'Role Model', 'duracion' => 263],
                ]
            ],
            [
                'nombre_artista' => 'Blood Orange',
                'genero' => 'Alternative R&B',
                'canciones' => [
                    ['titulo' => 'Charmer Baby', 'duracion' => 260],
                    ['titulo' => "Sandra's Smile", 'duracion' => 191],
                    ['titulo' => 'Best to You', 'duracion' => 231],
                    ['titulo' => 'Juicy 1-2', 'duracion' => 191],
                ]
            ],
            [
                'nombre_artista' => 'PinkPantheress',
                'genero' => 'Bedroom Pop',
                'canciones' => [
                    ['titulo' => 'Just for me', 'duracion' => 108],
                    ['titulo' => 'Break it off', 'duracion' => 119],
                    ['titulo' => 'Pain', 'duracion' => 149],
                    ['titulo' => "I'm gonna love you", 'duracion' => 135],
                ]
            ],
            [
                'nombre_artista' => 'Still Woozy',
                'genero' => 'Indie Electronic',
                'canciones' => [
                    ['titulo' => 'Goodie Bag', 'duracion' => 220],
                    ['titulo' => 'Habit', 'duracion' => 208],
                    ['titulo' => 'Cooks', 'duracion' => 219],
                    ['titulo' => 'Wooz', 'duracion' => 225],
                ]
            ],
            [
                'nombre_artista' => 'Toro y Moi',
                'genero' => 'Chillwave',
                'canciones' => [
                    ['titulo' => 'Rose Quartz', 'duracion' => 196],
                    ['titulo' => 'Ordinary Pleasure', 'duracion' => 225],
                    ['titulo' => 'Freelance', 'duracion' => 223],
                    ['titulo' => 'Lemuria', 'duracion' => 201],
                ]
            ],
            [
                'nombre_artista' => 'Washed Out',
                'genero' => 'Chillwave',
                'canciones' => [
                    ['titulo' => 'Feel It All Around', 'duracion' => 234],
                    ['titulo' => 'Amor Fati', 'duracion' => 259],
                    ['titulo' => "It's All Good", 'duracion' => 230],
                    ['titulo' => 'Echoes', 'duracion' => 219],
                ]
            ],
            [
                'nombre_artista' => 'Tycho',
                'genero' => 'Ambient/OST',
                'canciones' => [
                    ['titulo' => 'Awake', 'duracion' => 287],
                    ['titulo' => 'Division', 'duracion' => 238],
                    ['titulo' => 'See', 'duracion' => 278],
                    ['titulo' => 'Hours', 'duracion' => 278],
                ]
            ],
            [
                'nombre_artista' => 'Bonobo',
                'genero' => 'Downtempo',
                'canciones' => [
                    ['titulo' => 'Kiara', 'duracion' => 336],
                    ['titulo' => 'Kerala', 'duracion' => 284],
                    ['titulo' => 'Bambro Koyo Ganda', 'duracion' => 290],
                    ['titulo' => 'First Fires', 'duracion' => 301],
                ]
            ],
            [
                'nombre_artista' => 'FKA twigs',
                'genero' => 'Avant-pop',
                'canciones' => [
                    ['titulo' => 'Cellophane', 'duracion' => 186],
                    ['titulo' => 'home with you', 'duracion' => 224],
                    ['titulo' => 'sad day', 'duracion' => 208],
                    ['titulo' => 'holy terrain', 'duracion' => 230],
                ]
            ],
            [
                'nombre_artista' => 'James Blake',
                'genero' => 'Post-electronic',
                'canciones' => [
                    ['titulo' => 'Retrograde', 'duracion' => 239],
                    ['titulo' => 'Limit to Your Love', 'duracion' => 276],
                    ['titulo' => 'The Wilhelm Scream', 'duracion' => 248],
                    ['titulo' => 'I Need a Forest Fire', 'duracion' => 264],
                ]
            ]
        ];

        // 5. PROCESAR ARTISTAS Y SUS CANCIONES
        foreach ($artistasConCanciones as $artistaData) {
            // Buscar o crear el género
            $generoNombre = $artistaData['genero'];
            $genero = collect($generosCreados)->firstWhere('nombre_genero', $generoNombre);
            if (!$genero) {
                // Si no existe, lo creamos (por si acaso)
                $genero = Genero::create(['nombre_genero' => $generoNombre]);
                $generosCreados[] = $genero;
            }
            
            // Crear el artista
            $artista = Artista::create([
                'nombre_artista' => $artistaData['nombre_artista']
            ]);
            
            // Crear las canciones del artista
            foreach ($artistaData['canciones'] as $cancionDatum) {
                Cancion::create([
                    'titulo_cancion' => $cancionDatum['titulo'],
                    'duracion_cancion' => $cancionDatum['duracion'],
                    'id_artista_fk' => $artista->id_artista,
                    'id_genero_fk' => $genero->id_genero,
                    'ruta_portada_cancion' => 'storage/portadas/' . strtolower(str_replace(' ', '_', $cancionDatum['titulo'])) . '.jpg',
                    'ruta_audio_cancion' => 'storage/audio/' . strtolower(str_replace(' ', '_', $cancionDatum['titulo'])) . '.mp3',
                ]);
            }
        }

        // 6. CREAR USUARIOS ADICIONALES (para llegar a un total razonable)
        // Ya tenemos 3 específicos, vamos a crear 27 más para llegar a 30 total
        Usuario::factory()->count(27)->create();

        // 7. CREAR LISTAS DE REPRODUCCIÓN Y ASOCIAR CANCIONES
        // Obtener todos los usuarios
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            // Cada usuario tiene entre 2 y 8 listas (para tener más variedad)
            $numeroListas = rand(2, 8);

            for ($i = 0; $i < $numeroListas; $i++) {
                $lista = ListaReproduccion::create([
                    'id_usuario_fk' => $usuario->id_usuario,
                    'nombre_lista' => fake()->sentence(rand(2, 4), false), // 2-4 words without period
                    'es_publica_lista' => fake()->boolean(50), // 50% public
                ]);

                // Asociar entre 10 y 30 canciones aleatorias a esta lista
                // (más canciones por lista para hacerla más sustancial)
                $cancionesIds = Cancion::inRandomOrder()->limit(rand(10, 30))->pluck('id_cancion')->toArray();
                $lista->canciones()->attach($cancionesIds);
            }
        }
    }
}
