<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    //creamos relacion de muchos a muchos con la tabla compra
    public function compras(){
        //al igual que la tabla compras debemos hacer lo mismo cuando estas dos tablas estan relacionados con una tabla pivote
        return $this->belongsToMany(Compra::class)->withTimestamps()->withPivot('cantidad','precio_compra','precio_venta');
        //al igual que la anterior siempre se usa belongsToMany para muchos a muchos
    }
    //relacion de mcuhos a muchos con ventas
    public function ventas(){
        return $this->belongsToMany(Venta::class)->withTimestamps()->withPivot('cantidad','precio_venta','descuento'); 
    }

    //relacioni muchos a muchos con productos estas tienen tablas pivotes
    public function categorias(){
        return $this->belongsToMany(Categoria::class)->withTimestamps();//con withTimeStamps le damos fechas a las relaciones many to many 
        //categoria es el nombre del metodo y en este caso no colocamos whithpivot() ya que no hay mas campos aparte de las llaves foraneas
    }

    //relaciond e uno a muchos con marcas
    public function marca() {
        return $this->belongsTo(Marca::class);
    }

    //relacion de uno a muchos ya que aca está la llave foranea entonces aqui es en singular
    public function presentacione(){
        return $this->belongsTo(Presentacione::class);
    }

    //AGREGAMOS LA VARIABLE FILLABLE
    protected $fillable = ['codigo','nombre','descripcion','fecha_vencimiento','marca_id','presentacione_id','imagen_path'];

    //CREAMOS UNA FUNCION EN EL MODELO PARA CARGAR LA IMAGEN
    public function hanBleUploadImage($image){
        $file = $image;
        $name = time().$file->getClientOriginalName();
        //$file->move(public_path().'/img/productos/',$name);
        Storage::putFileAs('/public/productos/',$file,$name,'public');
        return $name;
    }

    //FUNCION PARA MOSTRAR LA IMAGEN
    public function getImageUrlAttribute()
{
    if ($this->imagen_path) {
        return asset('/storage/app/public/productos/'.$this->imagen_path);
    }
    // Si no hay imagen, puedes retornar una imagen por defecto o null
    // return asset('storage/default_image.jpg'); // Cambia 'default_image.jpg' por el nombre de tu imagen por defecto
    return null;
}

}
