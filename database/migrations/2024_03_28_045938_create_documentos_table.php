<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //ESTA FUNCION ES PARA CREAR NUESTRA TABLA
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            //VAMOS A LLENAR LOS CAMPOS DE LA TABLA CON LOS ATRIBUTROS QUE TIENE NUESTRA TABLA EN NUESTRO MODELO DE BASE DE DATOS
            $table->id();
            $table->string('tipo_documento',30); //aca estamos definiendo que nuestro modelo este campo tiene VARCHAR 30 de longitud
            $table->string('numero_documento',30);
            $table->timestamps(); // DENTRO DE ESTO ESTÁ CREATE APP Y UPDATE APP
        });
    }

    /**
     * Reverse the migrations.
     */
    // ESTA FUNCION ES PARA REVERTIR LA MIGRACION DE LA TABLA, ELIMINA SI EXISTE UNA IGUAL
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
