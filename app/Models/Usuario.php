<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_usuarios';
    protected $primaryKey = 'id_usuario'; // Clave primaria explícita

    protected $fillable = ['nombre_usuario', 'email_usuario', 'contrasena_usuario', 'rol_usuario', 'activo_usuario'];
    protected $hidden = ['contrasena_usuario', 'remember_token'];

    // Redirige la autenticación de Laravel a tu columna personalizada
    public function getAuthPassword()
    {
        return $this->contrasena_usuario;
    }

    public function listas(): HasMany
    {
        // Modelo, clave foránea en la tabla hija, clave local en esta tabla
        return $this->hasMany(ListaReproduccion::class, 'id_usuario_fk', 'id_usuario');
    }

    protected function casts(): array
    {
        return [
            'activo_usuario' => 'boolean',
        ];
    }
}
