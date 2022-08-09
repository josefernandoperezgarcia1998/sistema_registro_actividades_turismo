<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            Consultas
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('actividades.vista-consulta')}}">Registro general</a></li>
            @if (Auth::user()->rol == 'Administrador')
                <li><a class="dropdown-item" href="{{route('actividades.vista-consulta-por-servicios-todos')}}">Registro por servicios</a></li>
                <li><a class="dropdown-item" href="{{route('actividades.vista-consulta-por-unico-servicio')}}">Registro por único servicio</a></li>
            @endif
        </ul>
    </div>
</div>