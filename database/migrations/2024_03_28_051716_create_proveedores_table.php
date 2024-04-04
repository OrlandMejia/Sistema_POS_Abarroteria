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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'persona_id' )->unique()->constrained('personas')->onDelete(''); // sintaxis para utilizar o modelar una llave foranea, aca referenciamos
            //en este caso con foreignId que la llave foranea segun el modelo es persona_id de la tabla personas, LE CREAMOS TAMBIEN un metodo onDelete('cascade')
            //que hace que se elimine el registro relacionado si este ya no existe, es decir si se elimina algo de la tabla persona tambien su proveedor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
