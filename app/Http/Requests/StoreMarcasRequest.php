<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcasRequest extends FormRequest
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
        return [
            //validar nombre y descripcion para ingresarlo a la base de datos a traves del formulario
            //usamos propiedades de validación de laravel para decir que el nombre será de maximo 60 caracteries según nuestro diseño de la
            //base de datos, ademas de que será un valor unico de la tabla caractristicas de su campo nombre
            'nombre' => 'required|max:60|unique:caracteristicas,nombre', //esta propiedad required es porque es obligatorio que coloque eso en el campo
            'descripcion' => 'nullable|max:255' //a diferencia de descripcion que es opcional y decimos que puede ser null con max de 255 
        ];
    }
}
