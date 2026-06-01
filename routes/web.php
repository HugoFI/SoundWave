<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\CatalogoController;
use App\Http\Controllers\admin\UsuarioController;
use App\Http\Controllers\cliente\InicioController;
use App\Http\Controllers\cliente\ListaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/inicio', function () {
    return '';
})->middleware('redirigir.rol')->name('inicio');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'procesarLogin'])->name('login.procesar');

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro.form');
Route::post('/registro', [AuthController::class, 'procesarRegistro'])->name('registro.procesar');

Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->group(function () {
    Route::get('/', [InicioController::class, 'index'])->name('cliente.inicio');
    // Ruta para detalles de cancion especifica
    Route::get('/cancion/{id}', [InicioController::class, 'mostrarCancion'])->name('cliente.cancion');
    // Ruta para guardar cancion en listas
    Route::post('/cancion/{id}/listas', [InicioController::class, 'guardarEnListas'])->name('cliente.cancion.listas');
    // Busqueda ajax
    Route::get('/buscar-ajax', [InicioController::class, 'buscarAjax'])->name('cliente.buscar_ajax');
    // Cargar vista listas
    Route::get('/listas', [ListaController::class, 'index'])->name('cliente.listas');
    // Guardar nueva lista
    Route::post('/listas', [ListaController::class, 'guardar'])->name('cliente.listas.guardar');
    // Ver detalles lista
    Route::get('/listas/{id}', [ListaController::class, 'ver'])->name('cliente.listas.ver');
    });

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [CatalogoController::class, 'index'])->name('admin.catalogo');
    Route::get('/canciones/nueva', [CatalogoController::class, 'crear'])->name('admin.canciones.crear');
    Route::post('/canciones', [CatalogoController::class, 'guardar'])->name('admin.canciones.guardar');
    Route::get('/canciones/{id}/editar', [CatalogoController::class, 'editar'])->name('admin.canciones.editar');
    Route::post('/canciones/{id}', [CatalogoController::class, 'actualizar'])->name('admin.canciones.actualizar');
    Route::post('/canciones/{id}/eliminar', [CatalogoController::class, 'eliminar'])->name('admin.canciones.eliminar');
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
    Route::post('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])->name('admin.usuarios.estado');
    Route::get('/artistas-generos', [CatalogoController::class, 'artistasGeneros'])->name('admin.artistas-generos');
    Route::post('/artistas', [CatalogoController::class, 'guardarArtista'])->name('admin.artistas.guardar');
    Route::post('/generos', [CatalogoController::class, 'guardarGenero'])->name('admin.generos.guardar');
    Route::post('/artistas/{id}/eliminar', [CatalogoController::class, 'eliminarArtista'])->name('admin.artistas.eliminar');
    Route::post('/generos/{id}/eliminar', [CatalogoController::class, 'eliminarGenero'])->name('admin.generos.eliminar');
});
