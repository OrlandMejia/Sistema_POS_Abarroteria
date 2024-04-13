<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //antes de retornar la vista vamos a recuperar los datos de la db
        //usamos with para  pasarle variables a la vista, en este caso las categorias, mismo nombre que nuestra relacion en el modelo
        $categorias = Categoria::with('caracteristica')->latest()->get(); //usamos latest para mostrar en orden de creación
        //dd($categorias);
        //retornar la vista cada que vayamos al index de categorias
        //le asignamos a la vista una variable categorias para luego poder utilizarla en la vista
        return view('categoria.index',['categorias'=>$categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //retornamos la vista cuando colocamos en el navegador el link especifico de create
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        //request esta variable contiene un array que tiene los datos que guardaremos en nuestra base de datos
        //en este caso contiene el token, nombre y descripcion
        //dd($request);//solo para ver los datos del request, una vez lo tengas puedes eliminarlo
        //existen dos formas de validacion 
        /*
        1. dentro el propio metodo
        2. por medio de una clase llamada form request la cual se debe crear desde la terminal
        */

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
            $caracteristica->categoria()->create([
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
        return redirect()->route('categorias.index')->with('success','¡Categoria Registrada con Exito!');
        
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
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit',['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     * usamos esa clase en el http request que creamos para validar el update
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        //CREAMOS UN HTTP REQUEST
        //haremos la actualizacion masiva tambien
        Caracteristica::where('id',$categoria->caracteristica->id)->update($request->validated());
        return redirect()->route('categorias.index')->with('success','Categoria Editada');
    }

    /**
     * Remove the specified resource from storage.
     * funcion para cambiar el estado de la categoria, ahora si vamos a recibir el string id por eso lo dejamos ahi
     */
    public function destroy(string $id)
    {
        //cambiar el estado del producto para "eliminarlo"
        $message = '';
        $categoria = Categoria::find($id);
        if($categoria->caracteristica->estado == 1){
            Caracteristica::where('id',$categoria->caracteristica->id)->update([
                'estado' => 0
            ]);
            $message = 'Categoría Eliminada';
        }
        else{
            Caracteristica::where('id',$categoria->caracteristica->id)->update([
                'estado' => 1
            ]);
            $message = 'Categoría Restaurada';
        }

        //redireccionar despues de que cambie la categoria
        return redirect()->route('categorias.index')->with('success',$message);
    }
}
