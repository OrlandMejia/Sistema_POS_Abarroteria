<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacione;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('producto.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
