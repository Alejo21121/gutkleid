<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/ACTUALIZAR DATOS.css') }}">
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
    <div class="form-perfil">

        <h1>Actualiza Tus Datos</h1>

        <!-- Eliminar imagen -->
        <form action="{{ route('perfil.eliminarImagen') }}" method="POST">
            @csrf
            <div class="text-center">
                <button type="submit" class="botoncategor">Eliminar imagen de perfil</button>
            </div>
        </form>

        <!-- Form principal -->
        <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="imagen">Imagen de perfil</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </div>

            <div class="form-group">
                <label for="nombres">Nombre</label>
                <input type="text" name="nombres" value="{{ $usuario['nombres'] }}" required>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" value="{{ $usuario['apellidos'] }}" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" value="{{ $usuario['telefono'] }}" required>
            </div>

            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" name="correo" value="{{ $usuario['correo'] }}" required>
            </div>

            <div class="acciones">
                <button type="submit" class="botoningre">Guardar</button>
                <a href="{{ route('cuenta') }}"><button type="button" class="volve">Cancelar</button></a>
            </div>
        </form>

        @if(session('success'))
            <div style="color: green; margin-top: 15px; text-align:center;">
                {{ session('success') }}
            </div>
        @endif
    </div>
</main>

</body>
<br>
    <footer class="pie">
        <strong><a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a></strong>
        <strong><a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a></strong>
        <strong><a href="{{ route('reseñas') }}" class="abaj">Reseñas</a></strong>
        <strong><a href="{{ route('tiendas') }}" class="abaj">Tiendas</a></strong>
        <strong><a href="{{ route('redes') }}" class="abaj">Redes</a></strong>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>

</html>