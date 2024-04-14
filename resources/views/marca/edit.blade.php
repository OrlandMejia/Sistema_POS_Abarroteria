@extends('template')

@section('title','Editar Marca')

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
    <h1 class="mt-4 text-center">Editar marca-</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('marcas.index') }}">Marcas</a></li>
        <li class="breadcrumb-item">Editar Marca</a></li>
    </ol>
</div>

    <!--CREAMOS NUESTRO FORMULARIO Y COLOCAMOS QUE SEA TIPO POST Y QUE EL ACTION HACIA DONDE IRÁ SERÁ A LA FUNCION STORE PARA GUARDAR
    Tmbien decimos que será tipo contenedor que tendrá borde de 3 y border primary color azul con un padding de 4 y un margin top de 3-->
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('marcas.update', ['marca'=>$marca]) }}" method="POST">
            <!--usamos esto para que se actulice segun el route:list y sporte el post-->
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label"> <i class="fa-solid fa-pencil"></i> Nombre:</label>
                    <input class="form-control" placeholder="Ingrese el nuevo nombre de la Categoria" type="text" name="nombre" id="nombre" value="{{ old('nombre',$marca->caracteristica->nombre) }}">
                    @error('nombre')
                        <small class="text-danger">*{{ $message }}</small><br>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="descripcion" class="form-label"><i class="fa-solid fa-file-lines"></i> Descripción:</label>
                    <textarea name="descripcion" id="descripcion"  placeholder="Ingrese la nueva Descripcion" rows="3" class="form-control">{{ old('descripcion',$marca->caracteristica->descripcion) }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="reset" class="btn btn-secondary">Reiniciar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    
@endpush
