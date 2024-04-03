<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentacione extends Model
{
    use HasFactory;
    //presentaciones es la principal ya que la llave foranea está en prodcutos
    public function productos(){
        return $this->hasMany(Producto::class);
    }

    //relacion de UNO A UNO con caracteristicas a la inversa
    public function caracteristica(){
        return $this->belongsTo(Caracteristica::class);
    }
}
