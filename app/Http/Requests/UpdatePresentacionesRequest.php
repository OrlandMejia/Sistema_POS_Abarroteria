<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentacionesRequest extends FormRequest
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
        //RECUPERAMOS LO QUE CONTIENE PRESENTACIONES
        $presentaciones = $this->route('presentacione');
        $caracteristicaId = $presentaciones->caracteristica->id;
        return [
            //
            'nombre'=> 'required|max:60|unique:caracteristicas,nombre,'.$caracteristicaId,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
