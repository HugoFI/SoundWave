<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'tbl_generos';
    protected $primaryKey = 'id_genero';
    protected $fillable = ['nombre_genero'];

    public function canciones(): HasMany
    {
        return $this->hasMany(Cancion::class, 'id_genero_fk', 'id_genero');
    }
}