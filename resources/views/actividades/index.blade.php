@extends('layouts.general')

@section('title_page', 'Servicios')

@section('content_page')
@section('content_page')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session('success') }}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card shadow p-3 mb-5 bg-body rounded">
    <div class="carrd-header">
        <div class="d-flex justify-content-between">
            <div>
                Servicios registrados
            </div>
            <div>
                <a href="{{route('actividades.create')}}" class="btn btn-primary btn-sm">Nuevo servicio</a>
                {{-- @if (Auth::user()->rol == 'Administrador') --}}
                    <a href="{{route('actividades.vista-consulta')}}" class="btn btn-primary btn-sm">Consultar</a>
                {{-- @endif --}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="actividadesTable">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Quien Reporta</th>
                    <th>Área</th>
                    <th>Atendió</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection


@push('css')
{{-- Inicio CDM's css para datatables --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
{{-- Fin cDN's css para datatables --}}

{{-- Inicio para datatable responsive  --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
{{-- Fin para datatable responsive  --}}
@endpush


@push('js')
    {{-- inicio CDN de jquery para datatables --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
{{-- Fin CDN de Jquery para datatables --}}

{{-- Inicio para responsive de datatables --}}
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
{{-- Fin para responsive de datatables --}}

<script>
$(document).ready(function () {
    $('#actividadesTable').DataTable({
        "serverSide": true,
        "ajax": "{{ url('actividades-data') }}",
        "columns": [
            {data: 'folio', name: 'folio'},
            {data: 'quien_reporta', name: 'quien_reporta'},
            {data: 'area', name: 'area.nombre'},
            {data: 'user', name: 'user.name'},
            {data: 'fecha_inicio', name: 'fecha_inicio'},
            {data: 'btn'},
        ],
        responsive: true,
        autoWidth: false,

        "language": {
        "lengthMenu": "Mostrar " +
            `<select class="custom-select custom-select-sm form-control form-control-sm">
                                    <option value='10'>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='-1'>Todo</option>
                                    </select>` +
            " registros por página",
        "zeroRecords": "Sin registros",
        "info": "Mostrando la página _PAGE_ de _PAGES_",
        "infoEmpty": "",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        'search': 'Buscar:',
        'paginate': {
            'next': 'Siguiente',
            'previous': 'Anterior'
            }
        },
    });
});
</script>
@endpush