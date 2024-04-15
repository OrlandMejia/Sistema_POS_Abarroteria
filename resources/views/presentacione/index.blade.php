@extends('template')

@section('title', 'Marcas')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
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
        <h1 class="mt-4 text-center">Presentaciones Registradas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Presentaciones</li>
        </ol>
        <div class="mb-4">
            <!--BOTON QUE NOS AYUDARÁ A REDIRIGIRNOS A UNA NUEVA VISTA PARA INCLUIR UNA NUEVA CATEGORIA-->
            <a href="{{ route('presentaciones.create') }}">
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
                        @foreach ($presentacione as $presentaciones)
                            <tr>
                                <td>{{ $presentaciones->caracteristica->nombre }}</td>
                                <td>{{ $presentaciones->caracteristica->descripcion }}</td>
                                <td>HOLA</td>
                                <td>COMO</td>
                            </tr>
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
