<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
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
            //CODIGO PARA VALIDACION DE DATOS
            //ESTAS REGLAS APARECERÁN ABAJO COMO UNA ADVERTENCIA ANTES DE ENVIAR ALGUN DATO FUNCIONAN ALGO ASI COMO UN REQUIRED  en HTML
            'codigo'=> 'required|unique:productos,codigo|max:50',
            'nombre'=> 'required|unique:productos,nombre|max:80',
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', //TIPO image, MIMES SON LAS EXTENSIONES ACEPTADAS Y 2048 SON EQUIVALENTES A 2MB
            //aca indicamos que este campo es requerido y es tipo entero y que debe existir en la tabla marcas en su campo de id
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required'
        ];
    }
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
