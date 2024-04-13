@extends('template')

@section('title', 'Categorias')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<!--COLOCAMOS UNA VALIDACION PARA CUANDO HAYAMOS REGISTRADO UN PRODUCTO O CATEGORIA CORRECTAMENTE-->
@if (session('success'))
<script>
    //vamos a mostrar diferentes mensajes de exito o error cuando hagamos alguna accion en nuestros formularios
    let message = "{{ session('success')}}";
    const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: "success",
  title: message
});
</script>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Categorias</li>
    </ol>
<!--AÑADIR UN ESPACIO ENTRE EL BOTON Y LA TABLA-->
<div class="mb-4">
<!--BOTON QUE NOS AYUDARÁ A REDIRIGIRNOS A UNA NUEVA VISTA PARA INCLUIR UNA NUEVA CATEGORIA-->
<a href="{{ route('categorias.create') }}">
    <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Añadir Nuevo Registro</button>
</a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1">
        </i>
        Tabla Categorias
    </div>

    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <!--SE MANDAN LAS VARIABLES DEL ARCHIVO CONTROLLER AL HTML-->
                            <!--en este caso recorremos el array que contiene la variable categorias y decimos que lo que tenga su relacion
                                de caracteristica nos traiga lo que es el nombre-->
                            <td> {{ $categoria->caracteristica->nombre  }} </td>
                            <td> {{ $categoria->caracteristica->descripcion}}</td>
                            <td> 
                                <!--INDCAMOS QUE SI LO QUE RECORRE EL ARREGLO CATEGORIA EN LA TABLA CARACTERISTICA SU ESTADO ES UNO
                                    ENTONCES MUESTRA UN SPAN CON UN FW BOLDER PARA QUE APAREZCA EN NEGRITA, UN ROUNDED PARA QUE SEA CON
                                    BORDER REDONDEADOS, UN PADDING P-1 DE UNO, UN BACKGROUND BG-SUCCESS Y UN TEXTO BLANCO WITHE-->
                                @if ($categoria->caracteristica->estado == 1) 
                                <span class="fw-bolder rounded p-1 bg-success text-white">Activo</span>
                                @else
                                <span class="fw-bolder rounded p-1 bg-danger text-white">Eliminado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{route('categorias.edit',['categoria'=>$categoria])}}" method="GET">
                                        <button type="submit" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    </form>
                                    @if ($categoria->caracteristica->estado == 1)
                                    <button type="button" class="btn btn-danger" style="margin-left: 10px; border-radius: 5px;" 
                                    data-bs-toggle="modal" data-bs-target="#confirmacion-{{$categoria->id}}">
                                    <i class="fa-solid fa-trash"></i> Eliminar</button>
                                    @else
                                    <button type="button" class="btn btn-success" style="margin-left: 10px; border-radius: 5px;" 
                                    data-bs-toggle="modal" data-bs-target="#confirmacion-{{$categoria->id}}">
                                    <i class="fas fa-undo"></i>Restaurar</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="confirmacion-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!--ACA USAREMOS UN OPERADOR TERNIARIO PARA PODER MOSTRAR LOS MENSAJES DE MEJOR MANERA YA SEA PARA
                                        ESCOGER LA OPCION DE ELIMINAR O ESCOGER LA OPCION DE RESTAURAR-->
                                {{ $categoria->caracteristica->estado == 1 ? '¿Está seguro de Eliminar la Categoria?' : '¿Seguro que quiere Restaurar esta categoria?'}}
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                
                                <form action="{{ route('categorias.destroy',['categoria'=>$categoria->id])}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    @if ($categoria->caracteristica->estado == 1)
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                    @else
                                    <button type="submit" class="btn btn-success">Confirmar</button>
                                    @endif
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        @endforeach
                </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush