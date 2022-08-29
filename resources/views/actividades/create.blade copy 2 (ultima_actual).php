@extends('layouts.general')

@section('title_page', 'Servicios')

@section('content_page')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session('error') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="card-header">
        Completa el siguiente formulario
    </div>
    <div class="card-body">
        <form id="formulario" action="{{ route('actividades.store') }}" method="post" enctype="multipart/form-data"
            class="needs-validation" novalidate autocomplete="off">
            @csrf
            <div class="">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label for="quien_reporta" class="form-label">¿Quién reporta?</label>
                            <input type="text" class="form-control" id="quien_reporta" name="quien_reporta"
                                value="{{ old('quien_reporta') }}" autocomplete="off" required>
                            @error('quien_reporta')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="area" class="form-label">Área de adscripción</label>
                        <select class="form-control" id="area-search" name="area_id" value="{{old('area_id')}}">
                            @if(Request::old('area_id') != NULL)
                                <option value="{{old('area_id')}}">{{$areas->where('id', intval(Request::old('area_id')))->first()->nombre}}</option>
                            @endif
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
                            <label for="servicio" class="form-label">Tipo de servicio</label>
                            <select class="form-control" id="servicio-search" name="servicio_id" value="{{old('servicio_id')}}">
                                @if(Request::old('servicio_id') != NULL)
                                    <option value="{{old('servicio_id')}}">{{$servicios->where('id', intval(Request::old('servicio_id')))->first()->nombre}}</option>
                                @endif
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
                            <textarea class="form-control" id="descripcion" name="descripcion"
                                rows="3">{{old('descripcion')}}</textarea>
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
                            <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio"
                                value="{{ old('fecha_inicio') }}">
                            @error('fecha_inicio')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm">
                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                        <input class="form-control" type="date" name="fecha_fin" id="fecha_fin"
                            value="{{ old('fecha_fin') }}" onchange="ValidarFechas();">
                        @error('fecha_fin')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</div>
@endsection

@push('css')
{{-- inicio de cdns para select2 --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
{{-- Fin de cdns para select2 --}}

@endpush


@push('js')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    function ValidarFechas() {
        var fechainicial = document.getElementById("fecha_inicio").value;
        var fechafinal = document.getElementById("fecha_fin").value;

        if (Date.parse(fechafinal) < Date.parse(fechainicial)) {

            $('#fecha_fin').val("");
            alert("La fecha final debe ser mayor a la fecha inicial");
        }
    }

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = mm + '/' + dd + '/' + yyyy;
    console.log(mm);

</script>

<script>
    
    var path_area_search = "{{ route('actividades.areaSearch') }}";

    $('#area-search').select2({
        placeholder: 'Selecciona un area',
        ajax: {
            url: path_area_search,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nombre,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    var path_servicio_search = "{{ route('actividades.servicioSearch') }}";

    $('#servicio-search').select2({
        placeholder: 'Selecciona un servicio',
        ajax: {
            url: path_servicio_search,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nombre,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

</script>
@endpush
