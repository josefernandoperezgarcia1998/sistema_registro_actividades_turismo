@extends('layouts.general')

@section('title_page', 'Editar servicio')

@section('content_page')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="card-header">
        Completa el siguiente formulario
    </div>
    <div class="card-body">
        <form id="formulario" action="{{ route('actividades.update', $actividad->id) }}" method="post" enctype="multipart/form-data"
            class="needs-validation" novalidate autocomplete="off">
            @csrf
            @method('PUT')
            <div class="">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label for="quien_reporta" class="form-label">¿Quién reporta?</label>
                            <input type="text" class="form-control" id="quien_reporta" name="quien_reporta"
                                value="{{ old('quien_reporta', $actividad->quien_reporta) }}" autocomplete="off" required>
                        @error('quien_reporta')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="area" class="form-label">Área de adscripción</label>
                        <select class="form-select" name="area_id" value="{{ old('area_id') }}" required>
                            <option value="" selected>Seleccionar área</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @if ($actividad->area_id === $area->id || old('area_id') ===
                                $area->id) selected @endif>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3 w-50">
                            <label for="area" class="form-label">Tipo de servicio</label>
                            <select class="form-select" name="servicio_id" value="{{ old('servicio_id') }}" required>
                                <option value="" selected>Seleccionar servicio</option>
                                @foreach ($servicios as $servicio)
                                <option value="{{ $servicio->id }}" @if ($actividad->servicio_id === $servicio->id || old('servicio_id') ===
                                    $servicio->id) selected @endif>{{ $servicio->nombre }}
                                @endforeach
                            </select>
                            @error('servicio_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="usuario_id" value="{{Auth::user()->id}}">
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion"
                                name="descripcion" rows="3">{{old('descripcion', $actividad->descripcion)}}</textarea>
                                @error('descripcion')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                            <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $actividad->fecha_inicio) }}">
                            @error('fecha_inicio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                        <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin', $actividad->fecha_fin) }}">
                        @error('fecha_fin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
            <a class="btn btn-secondary btn-sm" href="{{route('actividades.index')}}">Volver</a>
        </form>
    </div>
</div>
@endsection

@push('css')

@endpush


@push('js')

@endpush
