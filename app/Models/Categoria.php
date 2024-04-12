<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    //relacion muchos a muchos con productos
    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps();
    }

    //relacion uno a uno a la inversa con caracteristicas
    public function caracteristica() {
        return $this->belongsTo(Caracteristica::class);
    }
    //guardamos unicamente el dato que se almacena en esa tabla en relación a categoria el cual es caracteristica segun el modelo
    protected  $fillable = [ 'caracteristica_id'];
}
