<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePresentacionesRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class presentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd($presentaciones);
        //mostramos ese objeto para luego poder iterar al mismo
        $presentacione = Presentacione::with('caracteristica')->latest()->get();
        return view('presentacione.index',['presentacione'=>$presentacione]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('presentacione.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionesRequest $request)
    {
        //HACEMOS LA INSERCIÓN MASIVA TANTO PARA LA TABLA PIVOTE COMO LA RELACIÓN
        try {
            //code...
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' =>$caracteristica->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            //throw $th;
            // En caso de que ocurra algún error durante la transacción, capturamos la excepción y ejecutamos lo siguiente:
            // Deshacemos todos los cambios realizados durante la transacción
            DB::rollBack();
        }
                //devolver un mensaje despues de recibir la respuesta del servidor HTTP RESPONSE y que muestre un mensaje de exito
                return redirect()->route('presentaciones.index')->with('success','!Presentación Registrada con Exito!');
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
        $message = '';
        $presentaciones = Presentacione::find($id);
        if($presentaciones->caracteristica->estado == 1){
            Caracteristica::where('id',$presentaciones->caracteristica->id)->update([
                'estado' => 0
            ]);
            $message = 'Presentacion Eliminada';
        }
        else{
            Caracteristica::where('id',$presentaciones->caracteristica->id)->update([
                'estado' => 1
            ]);
            $message = 'Presentación Restaurada';
        }

        //redireccionar despues de que cambie la categoria
        return redirect()->route('presentaciones.index')->with('success',$message);
    }
}
