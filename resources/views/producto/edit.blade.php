@extends('template')

@section('title', 'Editar Producto')
    
@push('css')
    <style>
        #descripcion{
            resize: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar un Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('productos.index') }}">Productos</a></li>
        <li class="breadcrumb-item">Editar Producto</a></li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <!-- UTILIZAMOS LA PROPIEDAD enctype= "multipart/form-data" PARA QUE LOS ARCHIVOS TIPO FILE SE ENVIEN-->
        <form action="{{ route('productos.update',['producto'=>$producto]) }}" method="POST" enctype="multipart/form-data">
            <!-- No olvidar el método para esto, esto lo dice Laravel en route list-->
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6 mb-2">
                    <label for="codigo" class="form-label"><i class="fas fa-barcode"></i> Código:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo',$producto->codigo)}}">
                    @error('codigo')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label"><i class="fas fa-font"></i> Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre',$producto->nombre)}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-12 mb-2">
                    <label for="descripcion" class="form-label"><i class="fas fa-file-alt"></i> Descripción:</label>
                    <textarea type="text" name="descripcion" id="descripcion" rows="4" class="form-control" >{{ old('descripcion',$producto->descripcion)}}</textarea>
                    @error('descripcion')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-6 mb-2">
                    <label for="fecha_vencimiento" class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de Vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" rows="4" class="form-control" value="{{ old('fecha_vencimiento',$producto->fecha_vencimiento)}}"></textarea>
                    @error('fecha_vencimiento')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                
                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label"><i class="fas fa-image"></i> Imagen: </label>
                    <input type="file" name="img_path" id="img_path" rows="4" class="form-control" value="{{ old('img_path')}}" accept="Image/*">
                    @error('img_path')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label"><i class="fas fa-tags"></i> Marcas: </label>
                    <select name="marca_id" id="marca_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona una Marca" data-size="5">
                        <!-- VAMOS A RECORRER LA VARIABLE MARCA PARA MOSTRARLO-->
                        @foreach ($marcas as $item)
                        <!-- ACA HAREMOS UN IF ELSE PARA VERIFICAR SI EL PRODUCTO POSEE UNA MARCA -->
                        @if ($producto->marca_id == $item->id)
                        <!-- ACA USAMOS LA PROPIEDAD SELECTED PARA QUE MUESTRE LA MARCA O LA OPCION QUE TIENE -->
                        <option selected value="{{ $item->id }}"{{ old('marca_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @else
                        <option value="{{ $item->id }}"{{ old('marca_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @endif 
                        @endforeach
                    </select>
                    @error('marca_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-6 mb-2">
                    <label for="presentacione_id" class="form-label"><i class="fas fa-box"></i> Presentaciones: </label>
                    <select name="presentacione_id" id="presentacione_id" class="form-control selectpicker show-tick" data-live-search="true" title="Selecciona una Presentacion" data-size="5">
                        <!-- VAMOS A RECORRER LA VARIABLE MARCA PARA MOSTRARLO-->
                        @foreach ($presentaciones as $item)
                        <!-- HACEMOS LO MISMO CON ESTO -->
                        @if ($producto->presentacione_id == $item->id)
                        <option selected value="{{ $item->id }}" {{ old('presentacione_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @else
                        <option value="{{ $item->id }}" {{ old('presentacione_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @endif
                            
                        @endforeach
                    </select>
                    @error('presentacione_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-md-6 mb-2">
                    <label for="categorias" class="form-label"><i class="fas fa-list"></i> Categorías: </label>
                    <select name="categorias[]" id="categorias" class="form-control selectpicker show-tick" data-live-search="true" multiple title="Selecciona una Categoria" data-size="5">
                        <!-- VAMOS A RECORRER LA VARIABLE MARCA PARA MOSTRARLO-->
                        @foreach ($categorias as $item)
                        <!-- En esta parte utilizaremos un método de PHP llamado in_array -->
                        <!-- Aca decimos que si en el array se encuentra el item id y si este id es igual al que está en categorias en su columna id con pluck
                            ademas de que eso nos arroja una coleccion de datos y con toarray se convierte en un arreglo para comparar-->
                        @if (in_array($item->id,$producto->categorias->pluck('id')->toArray()))
                        <option selected value="{{ $item->id }}" {{ (in_array($item->id, old('categorias',[]))) ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @else
                        <option value="{{ $item->id }}" {{ (in_array($item->id, old('categorias',[]))) ? 'selected' : '' }}>{{ $item->nombre}}</option>
                        @endif
                            
                        @endforeach
                    </select>
                    @error('categorias')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
        
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Producto</button>
                </div>
            </div>
        </form>
        
    </div>
</div>
@endsection

@push('js')
    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>


@endpush