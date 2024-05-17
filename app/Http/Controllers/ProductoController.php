<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacione;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //DEVOLVEMOS TODOS LOS PRODUCTOS, con el punto hacemos referencia a su relacion con esa tabla ademas de latest que trae lo mas reciente ingresado
        $productos = Producto::with(['categorias.caracteristica','marca.caracteristica','presentacione.caracteristica'])->latest()->get(); //with se usa para mostrar varias tablas en una sola consulta
        //dd($productos);
        
        return view('producto.index',['productos'=>$productos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //PARA MANDAR A LLAMAR A LAS MARCAS CREAMOS UNA VARIABLE QUE LLAME A TODAS LAS MARCAS
        //AHORA PARA QUE NOS MUESTRE UNICAMENTE LAS MARCAS QUE ESTÁN ACTIVAS UTILIZAMOS EL METODO JOIN PARA UNIR TABLAS
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        // $marcas = select * from caracteristicas join marcas on marcas.caracteristica_id = caracteristicas.id where caracteristicas.estado = 1;
        
        //AHORA HACEMOS EXACTAMENTE LO MISMO CON LAS PRESENTACIONES QUE SE NOS SOLICITAN
        $presentaciones = Presentacione::join('caracteristicas as c','presentaciones.caracteristica_id','=','c.id')
        ->select('presentaciones.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        
        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        //dd($marcas);
        //VAMOS A MANDARLA A LA VISTA .CREATE A TRAVES DEL METODO COMPACT
        return view('producto.create',compact('marcas','presentaciones','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        //
        try {
            //code...
            DB::beginTransaction();
            $producto = new Producto();
            if($request->hasFile('img_path')){
                $name = $producto->hanBleUploadImage($request->file('img_path'));
            }else{
                $name = null;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'imagen_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacione_id' => $request->presentacione_id
            ]);

            $producto->save();

            //TABLA CATEGORIA PRODUCTO
            $categorias =  $request->get('categorias');
            $producto->categorias()->attach($categorias);
            
            DB::commit();
        } catch (Exception $e) {
            //throw $th;
            dd($e);
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto Registrado');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //ACA HICIMOS LAS CONSULTAS CORRESPONDIENTES AHORA LAS VARIABLES LAS VAMOS A UTILIZAR EN LA VISTA Y PODER MANIPULARLAS
        //AHORA PARA QUE NOS MUESTRE UNICAMENTE LAS MARCAS QUE ESTÁN ACTIVAS UTILIZAMOS EL METODO JOIN PARA UNIR TABLAS
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        // $marcas = select * from caracteristicas join marcas on marcas.caracteristica_id = caracteristicas.id where caracteristicas.estado = 1;
        
        //AHORA HACEMOS EXACTAMENTE LO MISMO CON LAS PRESENTACIONES QUE SE NOS SOLICITAN
        $presentaciones = Presentacione::join('caracteristicas as c','presentaciones.caracteristica_id','=','c.id')
        ->select('presentaciones.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        
        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        return view('producto.edit',compact('producto','marcas','presentaciones','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        //PROCEDIMIENTO PARA ACTUALIZAR EL PRODUCTO
        try {
            //code...
            DB::beginTransaction();
            if($request->hasFile('img_path')){
                $name = $producto->hanBleUploadImage($request->file('img_path'));
                
                //ELIMINAR SI EXISTE UNA IMAGEN
                if(Storage::disk('public')->exists('productos/'.$producto->img_path)){
                    Storage::disk('public')->delete('productos/'.$producto->img_path);
                }
            }else{
                $name = $producto->imagen_path;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'imagen_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacione_id' => $request->presentacione_id
            ]);

            $producto->save();

            //TABLA CATEGORIA PRODUCTO
            $categorias =  $request->get('categorias');
            $producto->categorias()->sync($categorias); //con sync elimina las categorias existentes y luego añade el nuevo arreglo
            
            DB::commit();
        } catch (Exception $e) {
            //throw $th;
            dd($e);
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto Editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //PROCEDIMIENTO PARA "ELIMINAR" EL PRODUCTO
        $message = '';
        $producto = Producto::find($id);
        if($producto->estado == 1){
            Producto::where('id',$producto->id)->update([
                'estado' => 0
            ]);
            $message = 'Producto Eliminado';
        }
        else{
            Producto::where('id',$producto->id)->update([
                'estado' => 1
            ]);
            $message = 'Producto Restaurado';
        }

        //redireccionar despues de que cambie la categoria
        return redirect()->route('productos.index')->with('success',$message);
        
    }
}
