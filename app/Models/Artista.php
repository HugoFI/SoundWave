<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artista extends Model
{
    protected $table = 'tbl_artistas';
    protected $primaryKey = 'id_artista';
    protected $fillable = ['nombre_artista'];

    public function canciones(): HasMany
    {
        return $this->hasMany(Cancion::class, 'id_artista_fk', 'id_artista');
    }
}
