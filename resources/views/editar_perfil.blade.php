<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/ACTUALIZAR DATOS.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="icon" href="IMG/icono2.ico" class="imagenl" type="image/x-icon">
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ url()->previous() }}">
                    <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
                </a>
                <button class="filter-btn">Acerca de</button>
            </div>
            <div class="logo">
                <a href="PAGINA PRINCIPAL.php">
                    <a href="{{ route('inicio') }}"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
                </a>
            </div>
            </div>
            <div class="barra2">
                <div class="usuario-info">
                    @if (session('usuario'))
                        <a href="{{ url('/logout') }}">
                            <button class="filter-btn"><i class="bi bi-door-open"></i></button>
                        </a>
                    @else
                        <p class="filter-btn">
                            <a href="{{ route('login') }}">Inicia sesión</a>
                        </p>
                    @endif
                </div>
        </nav>
    </header>
</head>
<br>

<body>
    <div class="form-container">
    <center><h1>Actualiza Tus Datos</h1></center>

         <form action="{{ route('perfil.eliminarImagen') }}" method="POST">
                @csrf
                <center><button type="submit" class="filter-bcc">Eliminar imagen de perfil</button></center>
            </form>
    
        <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="imagen">Imagen de perfil:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </div>

            <label for="nombres">Nombre:</label>
            <input type="text" name="nombres" value="{{ $usuario['nombres'] }}" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" value="{{ $usuario['apellidos'] }}" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" value="{{ $usuario['telefono'] }}" required>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" value="{{ $usuario['correo'] }}" required>

            <center>
                <button type="submit" class="filter-bcc">Guardar</button>
                <a href="{{ route('cuenta') }}"><button type="button" class="filter-bcc">Cancelar</button></a>
            </center>
        </form>

        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif
    </div>
</body>
<br>
<footer class="pie">
    <div class="foot">
        <br>
        <a href="TERMINOS Y CONDICIONES.html" class="abaj">Términos y Condiciones</a>
        <a href="PREGUNTAS FRECUENTES.html" class="abaj">Preguntas Frecuentes</a>
        <center>
            <h6>&copy; 2024 - GUT KLEID.</h6>
        </center>
    </div>
</footer>

</html>