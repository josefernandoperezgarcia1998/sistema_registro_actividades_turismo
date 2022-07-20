<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{asset('assets/dist/css/css_dashboard/dashboard.css')}}" rel="stylesheet" />
    <link rel="icon" href="{{asset('assets/img/favicon_chiapas.png')}}">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/inicio"><img src="{{asset('assets/img/logo_sectur.png')}}" alt="logo_sectur" width="140" height="63"></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                @include('layouts.sidebar')
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Tablero Principal</h1>
                </div>
                <div class="container">
                    <div class="row">
                        <!-- Content here -->
                        @if (Auth::user()->rol == 'Administrador')
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pc-display-horizontal" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z" />
                                    </svg>
                                </h5>
                                <p class="card-text">Apartado con información de los servicios</p>
                                <small><strong> Total de servicios:</strong> {{ $actividadCount }}</small>
                                <br><br>
                                <a href="{{ route('actividades.index') }}" class="card-link btn btn-primary btn-sm">Ver más...</a>
                            </div>
                        </div>
                        &nbsp;&nbsp;
                        &nbsp;
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Catálogo de servicios
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                                    </svg>
                                </h5>
                                <p class="card-text">Catálogo de los tipos de Servicios</p>
                                <small><strong> Total de catálogos:</strong> {{ $catServicioCount }}</small>
                                <br><br>
                                <a href="{{ route('catalogo-servicios.index') }}" class="card-link btn btn-primary btn-sm pull-right">Ver más...</a>
                        
                            </div>
                        </div>
                        &nbsp;&nbsp;
                        &nbsp;
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person" viewBox="0 0 16 16">
                                        <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    </svg>
                                </h5>
                                <p class="card-text">Apartado con información del personal</p>
                                <small><strong> Total de usuarios:</strong> {{ $userCount }}</small>
                                <br><br>
                                <a href="{{ route('users.index') }}" class="card-link btn btn-primary btn-sm pull-right">Ver más...</a>
                        
                            </div>
                        </div>
                        &nbsp;&nbsp;
                        &nbsp;
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Áreas
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </h5>
                                <p class="card-text">Apartado con información de las áreas</p>
                                <small><strong>Total de áreas:</strong> {{ $areasCount }}</small>
                                <br><br>
                                <a href="{{ route('areas.index') }}" class="card-link btn btn-primary btn-sm pull-right">Ver más...</a>
                        
                            </div>
                        </div>
                        @else
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Servicios <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pc-display-horizontal" viewBox="0 0 16 16">
                                    <path
                                        d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z" />
                                    </svg>
                                </h5>
                                <p class="card-text">Apartado con información de los servicios</p>
                                <small><strong> Total de servicios:</strong> {{ $actividadCountPrestador }}</small>
                                <br><br>
                                <a href="{{ route('actividades.index') }}" class="card-link btn btn-primary btn-sm">Ver más...</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/dist/js/js_dashboard/dashboard.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>

</body>

</html>
