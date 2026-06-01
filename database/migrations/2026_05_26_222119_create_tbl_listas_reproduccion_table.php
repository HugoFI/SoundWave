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
        Schema::create('tbl_listas_reproduccion', function (Blueprint $table) {
            $table->id('id_lista');
            
            $table->unsignedBigInteger('id_usuario_fk');
            $table->foreign('id_usuario_fk')->references('id_usuario')->on('tbl_usuarios');
            
            $table->string('nombre_lista');
            $table->boolean('es_publica_lista')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_listas_reproduccion');
    }
};
