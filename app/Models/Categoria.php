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
}
