<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    //metodo de uno a uno con persona ya que aqui está la llave foranea de persona
    public function persona(){
        return  $this->belongsTo(Persona::class);
    }

    //Cuando la relación es de uno a muchos  se utiliza hasMany() en lugar de belongs y el nombre es en plural 
    //ya que un proveedor puede tener muchas compras y en el modelo ER la llave foranea la tiene compras por eso es plural
    public function compras(){
        return $this->hasMany(Compra::class);
    }
}
