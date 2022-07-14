@extends('layouts.general')

@section('title_page', 'Consultar servicios')

@section('content_page')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="card-header">
        Consultas por mes y año
    </div>
    <div class="card-body">
        <div class="">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Selecciona el mes y año
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form id="formulario" action="{{ route('actividades.consulta') }}" method="post"
                            enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-sm">
                                    <div class="mb-3">
                                        <label for="mes" class="form-label">Fecha de inicio</label>
                                        <select name="mes" id="mes" class="form-select">
                                            <option value="">Selecciona un mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        @error('fecha_inicio')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm w-50">
                                    <label for="fecha_fin" class="form-label">Fecha de inicio</label>
                                    <input class="form-control" type="number" name="ano" id="ano">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="anoActual" name="anoActual" checked>
                                        <label class="form-check-label" for="anoActual">Año actual</label>
                                    </div>
                                    @error('fecha_fin')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm" id="btnBuscar">Buscar</button>
                            <a href="{{route("actividades.excel")}}" class="btn btn-success btn-sm" id="botonExportar">Exportar Excel</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <small class="text-success">{{$mensaje}}</small>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Folio</th>
                            <th scope="col">Quien reporta</th>
                            <th scope="col">Area</th>
                            <th scope="col">Atendió</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actividades as $actividad)
                        <tr>
                            <td>{{ $actividad->folio }}</td>
                            <td>{{ $actividad->quien_reporta }}</td>
                            <td>{{ $actividad->area->nombre }}</td>
                            <td>{{ $actividad->user->name }}</td>
                            <td>{{ $actividad->fecha_inicio }}</td>
                        </tr>
                        
                        @empty
                            <tr>
                                <td>Sin registros</td>
                            </tr>
                        @endforelse
                </table>
                <small>Total de registros encontrados: <strong>{{ $actividadesCount }}</strong></small>
            </div>
        </div>
    </div>
    @endsection

    @push('css')

    @endpush


    @push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <script>

        // Obteniendo la fecha actual
        var currentTime = new Date();
        var year = currentTime.getFullYear()

        //Desactivando el input input
        $('#ano').val(year);
        $('#ano').prop( "readonly", true);

        $("#anoActual").on( 'change', function() {
            if( $(this).is(':checked') ) {
                // Hacer algo si el checkbox ha sido seleccionado
                $('#ano').val(year);
                $('#ano').prop( "readonly", true);
            } else {
                // Hacer algo si el checkbox ha sido deseleccionado
                $('#ano').val('');
                $('#ano').prop( "readonly", false);
            }
        });
    </script>

    
    @endpush
