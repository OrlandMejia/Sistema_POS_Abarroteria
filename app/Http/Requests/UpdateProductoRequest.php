<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
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
        //RECUPERAMOS EL VALOR QUE TENIA EL PRODUCTO
        $producto = $this->route('producto');
        return [
            // REGLAS DE VALIDACIÓN
            'codigo'=> 'required|unique:productos,codigo,'.$producto->id.'|max:50', // aca decimos que ignore que ya existe ese nombre que se guarda en esa variable para que no salte la validacion
            'nombre'=> 'required|unique:productos,nombre,'.$producto->id.'|max:80', // significa que no es necesario cambiar el codigo o el nombre para editar algun aspecto
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'imagen_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', //TIPO image, MIMES SON LAS EXTENSIONES ACEPTADAS Y 2048 SON EQUIVALENTES A 2MB
            //aca indicamos que este campo es requerido y es tipo entero y que debe existir en la tabla marcas en su campo de id
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required'
        ];
    }
    // ATRIBUTOS
    //PARA MOSTRAR UN MENSAJE PERSONALIZADO para que muestre lo que deseamos en la advertencia
    //LA FUNCION ATTRIBUTES YA VIENE ESTABLECIDA EN LARAVEL
    public function attributes(){
        return[
            'marca_id' => 'marca',
            'presentacione_id' => 'presentación'
        ];
    }
    //TAMBIEN EXISTE OTRA FUNCION LLAMADA MESSAGE() QUE RETORNA UN ARREGLO Y A DIFERENCIA DE LA ANTERIOR
    //ESTA PERMITE PERSONALIZAR LOS MENSAJES
    public function messages(){
        return [
            'codigo.required' => 'El Codigo es requerido para Registrar'
        ];
    }
}
