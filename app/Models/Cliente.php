<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    //relacion a la inversa con persona ya que están asociadas de uno a uno
    public function persona() {
        return $this->belongsTo(Persona::class);
    }

    //hacemos el metodo segun la relación con ventas
    public function ventas(){
        return  $this->hasMany(Venta::class);
    }
}
