@extends('template')

@section('Productos')

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

@section('content')
    <!-- SECCION PARA MOSTRAR LA ALERTA-->
    @if (session('success'))
        <script>
            let message = "{{ session('success') }}";
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
        <h1 class="mt-4 text-center">Productos Registrados</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>
        <div class="mb-4">
            <!--BOTON QUE NOS AYUDARÁ A REDIRIGIRNOS A UNA NUEVA VISTA PARA INCLUIR UNA NUEVA CATEGORIA-->
            <a href="{{ route('productos.create') }}">
                <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Añadir Nuevo
                    Producto</button>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1">
                </i>
                Tabla Productos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Presentación</th>
                            <th>Categorias</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->marca->caracteristica->nombre }}</td>
                                <td>{{ $item->presentacione->caracteristica->nombre }}</td>
                                <td>
                                    @foreach ($item->categorias as $categoria)
                                        <div class="container">
                                            <div class="row">
                                                <span
                                                    class="m-1 rounded-pill p-1 bg-primary text-white text-center">{{ $categoria->caracteristica->nombre }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                <td style="text-align: center;">
                                    <!--INDCAMOS QUE SI LO QUE RECORRE EL ARREGLO CATEGORIA EN LA TABLA CARACTERISTICA SU ESTADO ES UNO
                                                ENTONCES MUESTRA UN SPAN CON UN FW BOLDER PARA QUE APAREZCA EN NEGRITA, UN ROUNDED PARA QUE SEA CON
                                                BORDER REDONDEADOS, UN PADDING P-1 DE UNO, UN BACKGROUND BG-SUCCESS Y UN TEXTO BLANCO WITHE-->
                                    @if ($item->estado == 1)
                                        <span class="rounded p-1 bg-success text-white">Activo</span>
                                    @else
                                        <span class="rounded p-1 bg-danger text-white">Eliminado</span>
                                    @endif
                                </td>
                                <!--PARA LAS ACCIONES-->
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('productos.edit', ['producto' => $item]) }}" method="GET">
                                            <button type="submit" class="btn btn-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i> Editar</button>
                                        </form>
                                        <button type="button" class="btn btn-primary"
                                            style="margin-left: 10px; border-radius: 5px;" data-bs-toggle="modal"
                                            data-bs-target="#ver-{{ $item->id }}">
                                            <i class="fa-solid fa-eye"></i> Ver</button>

                                        @if ($item->estado == 1)
                                            <button type="button" class="btn btn-danger"
                                                style="margin-left: 10px; border-radius: 5px;" data-bs-toggle="modal"
                                                data-bs-target="#confirmacion-{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i> Eliminar</button>
                                        @else
                                            <button type="button" class="btn btn-success"
                                                style="margin-left: 10px; border-radius: 5px;" data-bs-toggle="modal"
                                                data-bs-target="#confirmacion-{{ $item->id }}">
                                                <i class="fas fa-undo"></i>Restaurar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!--MODAL PARA LA ELIMINACION-->
                            <div class="modal fade" id="confirmacion-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $item->estado == 1 ? '¿Seguro que desea Eliminar el Producto?' : '¿Desea Restaurar el Producto?' }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <form action="{{ route('productos.destroy', ['producto' => $item]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                @if ($item->estado == 1)
                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                @else
                                                    <button type="submit" class="btn btn-success">Confirmar</button>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--MODAL PARA MOSTRAR LOS PRODUCTOS-->
                            <div class="modal fade " id="ver-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Producto: {{ $item->nombre }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="Stock" class=""><strong>Stock:</strong>  {{ $item->stock}}</label>   
                                            </div>
                                            <div class="row mb-3">
                                                <label for="Stock" class=""><strong>Fecha Vencimiento:</strong> {{ $item->fecha_vencimiento}}</label>   
                                            </div>
                                            <div class="row mb-3">
                                                <label><strong>Imagen:</strong></label>
                                                @if ($item->imagen_path != null)
                                                    <img src="{{ Storage::url('public/productos/'.$item->imagen_path) }}" class="img-thumbnail img-fluid border border-4 rounded" alt="Imagen del Producto" >
                                                @else
                                                    <img src="{{ Storage::url('public/system/imagen_not_found.jpg') }}" class="img-thumbnail img-fluid" alt="No disponible" >
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
