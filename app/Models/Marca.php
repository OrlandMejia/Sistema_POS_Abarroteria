<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    //aca fijamos la relacion principal ya que la llave foranea se encuentra en productos
    public function productos(){
        return $this->hasMany(Producto::class);//relacion de muchos a muchos
    //con la tabla Producto y con la clave foránea "marca_id" 
    }

    //relacion UNO A UNO a la inversa con caracteristicas
    public function caracteristica(){
        return $this->belongsTo(Caracteristica::class);
    }
    //se guarda en objeto los datos que se quieren guardar en la tabla caracteristica y que está enlazada con categoria
    protected  $fillable = [ 'caracteristica_id'];
}
