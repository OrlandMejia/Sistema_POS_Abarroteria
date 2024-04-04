<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    //en esta que es a la inversa aqui es de uno a mucho se usa unicamente en singular osea no es proveedores sino proveedore
    //una compra solo puede tener un proveedor
    public function proveedore(){
        return  $this->belongsTo(Proveedore::class);
    }
    //realcion con comprante aca no es el principal
    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }

    //relacion de muchos a muchos de compras y productos
    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps()->withPivot('cantidad','precio_compra','precio_venta'); 
        //esto es para relaciones de muchos a muchos, donde indicamos con la propiedad withtimestamps que es para usar los metodos de
        //update y demas para tablas pivote que son de relaciones de muchos a muchos de igual forma el withpivot colocamos que campos
        //son los que tiene dicha tabla que no han sido utilizados.
    }
}

