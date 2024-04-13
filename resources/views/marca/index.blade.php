@extends('template')

@section('title', 'Marcas')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Marcas Registradas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Marcas</li>
        </ol>
        <div class="mb-4">
            <!--BOTON QUE NOS AYUDARÁ A REDIRIGIRNOS A UNA NUEVA VISTA PARA INCLUIR UNA NUEVA CATEGORIA-->
            <a href="{{ route('marcas.create') }}">
                <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Añadir Nueva Marca</button>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1">
                </i>
                Tabla Marcas
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
                        @foreach ($marcas as $marca)
                        <tr>
                            <td>{{ $marca->caracteristica->nombre }}</td>
                            <td>{{ $marca->caracteristica->descripcion }}</td>
                            <td style="text-align: center;">
                                <!--INDCAMOS QUE SI LO QUE RECORRE EL ARREGLO CATEGORIA EN LA TABLA CARACTERISTICA SU ESTADO ES UNO
                                    ENTONCES MUESTRA UN SPAN CON UN FW BOLDER PARA QUE APAREZCA EN NEGRITA, UN ROUNDED PARA QUE SEA CON
                                    BORDER REDONDEADOS, UN PADDING P-1 DE UNO, UN BACKGROUND BG-SUCCESS Y UN TEXTO BLANCO WITHE-->
                                @if ($marca->caracteristica->estado == 1)
                                    <span class="rounded p-1 bg-success text-white">Activo</span>
                                @else
                                    <span class="rounded p-1 bg-danger text-white">Eliminado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('marcas.edit', ['marca' => $marca]) }}" method="GET">
                                        <button type="submit" class="btn btn-warning"><i
                                                class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    </form>
                                    @if ($marca->caracteristica->estado == 1)
                                        <button type="button" class="btn btn-danger"
                                            style="margin-left: 10px; border-radius: 5px;" data-bs-toggle="modal"
                                            data-bs-target="#confirmacion-{{ $marca->id }}">
                                            <i class="fa-solid fa-trash"></i> Eliminar</button>
                                    @else
                                        <button type="button" class="btn btn-success"
                                            style="margin-left: 10px; border-radius: 5px;" data-bs-toggle="modal"
                                            data-bs-target="#confirmacion-{{ $marca->id }}">
                                            <i class="fas fa-undo"></i>Restaurar</button>
                                    @endif
                                </div>
                            </td>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
@endsection

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
        <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    @endpush
