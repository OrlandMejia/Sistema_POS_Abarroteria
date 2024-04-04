<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    use HasFactory;

    //creacion de metodos principales para la relacion de UNO A UNO con categorias, marcas y presentaciones
    public function categoria(){
        return $this->hasOne(Categoria::class);//relacion uno a uno
    }

    //uno a uno con marcas
    public function marca(){
        return $this->hasone(Marca::class);
    }

    //uno a uno con prsentaciones
    public function presentacione(){
        return $this->hasOne(Presentacione::class);
    }
}
