<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ListaReproduccion extends Model
{
    protected $table = 'tbl_listas_reproduccion';
    protected $primaryKey = 'id_lista';
    
    protected $fillable = ['id_usuario_fk', 'nombre_lista', 'es_publica_lista'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_fk', 'id_usuario'); 
    }

    public function canciones(): BelongsToMany
    {
        return $this->belongsToMany(
            Cancion::class, 
            'tbl_cancion_lista', 
            'id_lista_fk', 
            'id_cancion_fk', 
            'id_lista', 
            'id_cancion'
        );
    }
}
