<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cancion extends Model
{
    use HasFactory;

    protected $table = 'tbl_canciones';
    protected $primaryKey = 'id_cancion';
    public $timestamps = false;
    
    protected $fillable = [
        'titulo_cancion', 'duracion_cancion', 'id_artista_fk', 'id_genero_fk', 'ruta_portada_cancion', 'ruta_audio_cancion'
    ];
    
    public function artista(): BelongsTo
    {
        return $this->belongsTo(Artista::class, 'id_artista_fk', 'id_artista');
    }
    
    public function genero(): BelongsTo
    {
        return $this->belongsTo(Genero::class, 'id_genero_fk', 'id_genero');
    }
    
    public function listas(): BelongsToMany
    {
        // Definimos la tabla pivote y mapeamos todas las claves de la relación N a N
        return $this->belongsToMany(
            ListaReproduccion::class, 
            'tbl_cancion_lista', 
            'id_cancion_fk', 
            'id_lista_fk', 
            'id_cancion', 
            'id_lista'
        );
    }
}