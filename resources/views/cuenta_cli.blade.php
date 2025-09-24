<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/CUENTA CLIENTE.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>

<body id="my-account" class="page-my-account">

    <!-- HEADER -->
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                @if (session('usuario') && session('usuario')['id_rol'] == 1)
                <a class="filter-btn" href="{{ route('producto.index') }}">PANEL</a>
                @endif
            </div>

            <div class="logo">
                <a href="/">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                </a>
            </div>

            <div class="usuario-info">
                @if (session('usuario'))
                <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                <a href="{{ route('cuenta') }}">
                    <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil"
                        class="perfil-icono">
                </a>
                <a href="{{ route('logout') }}" class="filter-btn"><i class="bi bi-door-open"></i></a>
                @else
                <a href="{{ route('login') }}" class="inis">
                    <p class="filter-btn">INICIAR SESION</p>
                </a>
                @endif

                <!-- Carrito -->
                <a href="{{ route('carrito.index') }}" class="fontcarr">
                    <i class="bi bi-cart3"></i>
                </a>
            </div>
        </nav>
        <hr>
    </header>

    <!-- MAIN -->
    <main class="main">
        <div class="contenedor">
            <h1 class="title1">Información de tu Cuenta</h1>
            <div class="info">
                <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="foto" id="user-photo">
                <p><strong>Usuario:</strong><br>{{ session('usuario')['documento'] }}</p>
                <p><strong>Nombre Completo:</strong><br>{{ session('usuario')['nombres'] }}
                    {{ session('usuario')['apellidos'] }}
                </p>
                <p><strong>Fecha de Nacimiento:</strong><br>{{ session('usuario')['fecha_nacimiento'] }}</p>
                <p><strong>Teléfono:</strong><br>{{ session('usuario')['telefono'] }}</p>
                <p><strong>Direccion</strong><br>{{ session('usuario')['direccion'] }}</p>
                <p><strong>Correo:</strong><br>{{ session('usuario')['correo'] }}</p>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="pie">
        <strong><a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a></strong>
        <strong><a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a></strong>
        <strong><a href="{{ route('reseñas') }}" class="abaj">Reseñas</a></strong>
        <strong><a href="{{ route('tiendas') }}" class="abaj">Tiendas</a></strong>
        <strong><a href="{{ route('redes') }}" class="abaj">Redes</a></strong>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>
</body>

</html>
