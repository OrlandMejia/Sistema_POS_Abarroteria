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
  title: "¡Registro Guardado con Exito!"
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
    <button type="button" class="btn btn-primary">Añadir Nuevo Registro</button>
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
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                    </tr>
                    <tr>
                        <td>Jonas Alexander</td>
                        <td>Developer</td>
                        <td>San Francisco</td>
                        <td>30</td>
                        <td>2010/07/14</td>
                        <td>$86,500</td>
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