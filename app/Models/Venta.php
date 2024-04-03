<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    //creamos el metodo para relacionar venta con clientes
    public function cliente(){
        return $this->belongsTo(Cliente::class);//relacion de uno a muchos inversa 
    }

    //metodo con usuarios y ventas
    public function venta(){
        return $this->belongsTo(Venta::class); //relacion de uno a mucho
    }

    //relacion a la inversa con comprobantes
    public function comprovante(){
        return $this->belongsTo(Comprobante::class);
    }

    //metodo de relacion de muchos a muchos con productos
    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps()->withPivot('cantidad','precio_venta','descuento');
    }
}
