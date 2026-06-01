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
        Schema::create('tbl_cancion_lista', function (Blueprint $table) {
            $table->id('id_cancion_lista');
    
            $table->unsignedBigInteger('id_lista_fk');
            $table->foreign('id_lista_fk')->references('id_lista')->on('tbl_listas_reproduccion')->onDelete('cascade');
            
            // SIN cascade para poder aplicar tus Transacciones DB obligatorias en el borrado
            $table->unsignedBigInteger('id_cancion_fk');
            $table->foreign('id_cancion_fk')->references('id_cancion')->on('tbl_canciones');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cancion_lista');
    }
};

