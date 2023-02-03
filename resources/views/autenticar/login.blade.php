<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de actividades de la Unidad de Informática de la Secretaría de Turismo del Gobierno del Estado de Chiapas">
    <meta name="author" content="Secretaría de Turismo, Gobierno del Estado de Chiapas">
    <meta name="generator" content="Secretaría de Turismo">
    <title>Iniciar sesión</title>

    
    <!-- Favicons -->
    <link rel="icon" href="{{asset('assets/img/favicon_chiapas.png')}}">
    <meta name="theme-color" content="#712cf9">
    
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

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
          }
          
          .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
          }
          
          .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
          position: relative;
          z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
          }
          
        .nav-scroller .nav {
          display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
          }

    </style>
  <link href="{{asset('assets/dist/css/bootstrap-general/dist/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/dist/css/bootstrap-login/sign-in.css')}}" rel="stylesheet">
    <!-- Custom styles for this template -->
    {{-- <link href="https://getbootstrap.com/docs/5.2/examples/sign-in/signin.css" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
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
        <form action="{{ route('validar') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <img src="{{asset('assets/img/logo_sectur.png')}}" alt="logo-sectur-chiapas" >
            <h1 class="h3 mb-3 fw-normal">Inicia Sesión</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                    value="{{ old('email') }}">
                <label for="floatingInput">Correo electrónico</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                    name="password">
                <label for="floatingPassword">Contraseña</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; U. Informática - Secretaría de Turismo</p>
        </form>
    </main>
</body>

</html>