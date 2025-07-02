<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/CUENTA CLIENTE.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
<header class="cabeza">
    <nav class="barras">
        <div class="barra1">
            <a href="{{ url()->previous() }}">
                <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
            </a>
            <a href="{{ url('/reseñas') }}">
                <button class="filter-btn">Acerca de</button>
            </a>
        </div>

        <div class="logo">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
            </a>
        </div>

        <div class="barra2">
            <span class="user-name">Hola, {{ session('usuario')['nombres'] ?? 'Invitado' }}</span>
            <a href="{{ url('/logout') }}">
                <button class="filter-btn"><i class="bi bi-door-open"></i></button>
            </a>
            <a href="{{ route('carrito.index') }}">
                <button class="filter-btn"><i class="bi bi-cart3"></i></button>
            </a>
        </div>
    </nav>
</header>
    <main class="container">
        <h1 class="title1">Información de tu Cuenta</h1>
        <div class="info">
            <center>
                <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="foto" id="user-photo">
                <p><strong>Usuario:</strong><br>{{ session('usuario')['documento'] }}</p>
                <p><strong>Nombre Completo:</strong><br>{{ session('usuario')['nombres'] }}
                    {{ session('usuario')['apellidos'] }}
                </p>
                <p><strong>Teléfono:</strong><br>{{ session('usuario')['telefono'] }}</p>
                <p><strong>Dirección:</strong><br>{{ session('usuario')['direccion'] }}</p>
                <p><strong>Correo:</strong><br>{{ session('usuario')['correo'] }}</p>
            </center>
        </div>
        <center>
            <a href="{{ route('perfil.editar') }}"><button class="filter-bcc">Actualizar
                    Información</button></a><br><br>
            <a href="#"><button class="filter-bcc">Mis Pedidos</button></a><br><br>
        </center>
    </main>

    <footer class="pie">
        <div class="foot">
            <a href="{{ url('/terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ url('/preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            <center>
                <h6>&copy; 2024 - GUT KLEID.</h6>
            </center>
        </div>
    </footer>
</body>

</html>