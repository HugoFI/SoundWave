<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_canciones', function (Blueprint $table) {
            $table->id('id_cancion');
            $table->string('titulo_cancion');
            $table->integer('duracion_cancion'); // En segundos
            
            // Claves foráneas apuntando a sus respectivas tablas y columnas
            $table->unsignedBigInteger('id_artista_fk');
            $table->foreign('id_artista_fk')->references('id_artista')->on('tbl_artistas');

            $table->unsignedBigInteger('id_genero_fk');
            $table->foreign('id_genero_fk')->references('id_genero')->on('tbl_generos');
            
            $table->string('ruta_portada_cancion');
            $table->string('ruta_audio_cancion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_canciones');
    }
};
