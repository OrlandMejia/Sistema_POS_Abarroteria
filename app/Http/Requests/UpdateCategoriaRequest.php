<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //aca lo que hacemos es que recuperamos nuestra id de un elemento en especifico que es el que queremos modificar, haciendo
        /*
        primero, crear una variable categoria, donde las caractersticas tambien estan enlazadas, y tendrá como valor un this que apunte
        a la ruta de categoria que es el modelo el cual luego guardaremos en otra variable la categoria id de la tabla caracteristica
        y que apunte directamente al ID del producto o dato que estemos editando*/
        $categoria = $this->route('categoria');
        $caracteristicaId = $categoria->caracteristica->id;
        return [
            //CREAMOS NUESTRAS RESPECTIVAS REGLAS PARA LOS DATOS A MANIPULAR
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,'.$caracteristicaId,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
