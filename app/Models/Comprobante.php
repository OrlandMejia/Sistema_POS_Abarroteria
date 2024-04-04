<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    //usamos el metodo para la relacion principal un comprobante puede tener varias compras
    public function compras(){
        return $this->hasMany(Compra::class);
    }

    //creando relacion principal de comprovantes y ventas
    public function ventas() {
        return $this->hasMany(Venta::class);
    }
}
