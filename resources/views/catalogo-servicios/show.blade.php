@extends('layouts.general')

@section('title_page', 'Mostrar tipo de servicio')

@section('content_page')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="card-header">
        <strong>Tipo de servicio:</strong> {{$servicio->nombre }}
    </div>
    <div class="card-body">
        <form action="{{ route('catalogo-servicios.update', $servicio->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Datos de quién hace la denuncia -->
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre"
                                    value="{{ old('nombre', $servicio->nombre) }}" autocomplete="off">
                                    @error('nombre')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" name="estado">
                                    <option value="" selected>Seleccionar estado</option>
                                    <option
                                        {{ old('estado') == 'Si' ? 'selected' : ($servicio->estado == 'Si' ? 'selected' : '') }}
                                        value="Si">Si</option>
                                    <option
                                        {{ old('estado') == 'No' ? 'selected' : ($servicio->estado == 'No' ? 'selected' : '') }}
                                        value="No">No</option>
                                </select>
                                    @error('estado')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
            <a href="{{ route('catalogo-servicios.index') }}" class="btn btn-sm btn-secondary">Volver</a>
        </form>
    </div>
</div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
