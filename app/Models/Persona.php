<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    //aqui hacemos una relacion a la inversa ahora con documento
    public function documento(){
        return  $this->belongsTo(Documento::class); //belongsTo define una relación a la inversa en relaciones uno a uno
    }

    public function proveedore(){
        return  $this->hasOne(Proveedore::class);//relacion de uno a uno pero este es hasone porque la llave foranea está en la otra tabla
    }

    //funcion para clientes
    public function  cliente() {
        return $this->hasOne(Cliente::class);
    }
}
