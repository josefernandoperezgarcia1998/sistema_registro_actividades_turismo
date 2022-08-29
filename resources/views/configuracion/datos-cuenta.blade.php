@extends('layouts.general')

@section('title_page', 'Configuración')

@section('content_page')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif
<form action="{{ route('update-password') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input  type="text" class="form-control" name="name" value="{{old('name', $usuario->name)}}" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input  type="email" class="form-control" name="email" value="{{old('email', $usuario->email)}}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <input  type="text" class="form-control" name="rol" value="{{old('rol', $usuario->rol)}}" readonly>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Activo</label>
                        <input  type="text" class="form-control" name="estado" value="{{old('estado', $usuario->estado)}}"  readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label for="nota"><small><strong>En caso de no querer modificar la contraseña, dejar estos campos vacíos</strong></small>
        </label>
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña Antigua</label>
                        <input type="password" class="form-control" name="old_password" autocomplete="off">
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" name="new_password" autocomplete="off">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" name="new_password_confirmation" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">Volver</a>
</form>
@endsection

@push('css')
    
@endpush

@push('js')
    
@endpush