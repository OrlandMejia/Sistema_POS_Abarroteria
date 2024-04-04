<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    //creamos una funcion en documento ya que es una tabla con relación de uno a uno con la tabla persona y la llave foranea está en persona
    //ESTE ES EL METODO O FUNCION PRINCPAL
    public function persona(){
        return $this->hasOne(Persona::class); //se usa has one para relaciones de uno a uno y lo relacionamos con la clase persona
    }
}
