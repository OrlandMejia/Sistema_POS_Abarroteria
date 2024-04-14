<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcasRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class marcasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //SIEMPRE COLOCAR ESTO PARA USAR LA VARIABLE Y OBTENER LO QUE SE ENCUENTRA AHI Y USARLA EN UN FOREACH
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marca.index',['marcas'=>$marcas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //retornamos la vista
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcasRequest $request)
    {
        //d($request);
        //guardar categoria en base de datos
        try {
            // Inicio de la transacción
            DB::beginTransaction();
            //creamos la variable caracteristica la cual sera igual al metodo create del modelo y que traiga lo que tiene la variable
            //request validado en el objeto
            //como ya validamos en los modelos con fillable entonces obtendrá ese valor que se guardo en el request y lo guardará en la variable
            //cuando se cumpla eso entonces automaticamente guardará los registros en la base de datos
            $caracteristica = Caracteristica::create($request->validated());
            // aca lo que hacemos es que  le asignamos a un producto esa característica en la tabla directamente relacionada
            //diciendole que de la variable caracteristica en la tabla categoria cree un dato con el valor que se encuentra en
            //caracteristica id en la tabla, y lo guarde en el campo de caracteristica_id de la tabla categoria
            $caracteristica->marca()->create([
            'caracteristica_id' => $caracteristica->id
            ]);
            // Si no ocurren errores, confirmamos la transacción
            DB::commit();
        } catch (Exception $e) {
            // En caso de que ocurra algún error durante la transacción, capturamos la excepción y ejecutamos lo siguiente:
        
            // Deshacemos todos los cambios realizados durante la transacción
            DB::rollBack();
        }

        //devolver un mensaje despues de recibir la respuesta del servidor HTTP RESPONSE y que muestre un mensaje de exito
        return redirect()->route('marcas.index')->with('success','¡Marca Registrada con Exito!');
        
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
    public function edit(Marca $marca)
    {
        //dd($marca);
        //
        return view('marca.edit',['marca'=>$marca]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        //CREAMOS UN HTTP REQUEST
        //haremos la actualizacion masiva tambien
        /**
         * Caracteristica::where('id',$categoria->caracteristica->id)->update($request->validated());
           *return redirect()->route('categorias.index')->with('success','Categoria Editada');
         */
        Caracteristica::where('id',$marca->caracteristica->id)->update($request->validated());
        return redirect()->route('marcas.index')->with('success','Marca Editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $marca = Marca::find($id);
        if($marca->caracteristica->estado == 1){
            Caracteristica::where('id',$marca->caracteristica->id)->update([
                'estado' => 0
            ]);
            $message = 'Marca Eliminada';
        }
        else{
            Caracteristica::where('id',$marca->caracteristica->id)->update([
                'estado' => 1
            ]);
            $message = 'Marca Restaurada';
        }

        //redireccionar despues de que cambie la categoria
        return redirect()->route('marcas.index')->with('success',$message);
    }
}
