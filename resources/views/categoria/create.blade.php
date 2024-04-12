@extends('template')

@section('title','Crear categoria')

@push('css')
    <style>
        /*  Estilos para el formulario 
        donde el text area utilizando su name no pueda moverse a voluntad y este fija*/ 
        #descripcion{
          resize: none;  
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('categorias.index') }}">Categorias</a></li>
        <li class="breadcrumb-item">Crear Categoría</a></li>
    </ol>
<!--CREAMOS NUESTRO FORMULARIO Y COLOCAMOS QUE SEA TIPO POST Y QUE EL ACTION HACIA DONDE IRÁ SERÁ A LA FUNCION STORE PARA GUARDAR
    Tmbien decimos que será tipo contenedor que tendrá borde de 3 y border primary color azul con un padding de 4 y un margin top de 3-->
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <small class="text-danger">*{{ $message }}</small><br>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"  rows="3" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    
@endpush
