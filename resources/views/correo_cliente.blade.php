<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="CSS/RECUPERAR CUENTA.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="icon" href="IMG/icono2.ico" class="imagenl" type="image/x-icon" >
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <!-- IZQUIERDA -->
        <div class="nav-left">
            @if (session('usuario') && session('usuario')['id_rol'] == 1)
                <a class="filter-btn" href="{{ route('producto.index') }}">Panel</a>
            @endif
        </div>

        <!-- CENTRO -->
        <div class="nav-center">
            <a href="/">
            <div class="logo">
                <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
            </div></a>
        </div>
                <!-- Carrito -->
                <a href="{{ route('carrito.index') }}" class="fontcarr">
                    <i class="bi bi-cart3"></i>
                </a>
            </div>
        </div>
    </nav>
    <hr>
    <main class="main">
    <!-- Caja de login -->
    <div class="container-login">
        <form action="{{ route('enviar.codigo') }}" method="POST">
            @csrf
            <div class="login-form">
                <div class="form-group">
                    <label for="email"><h2>Ingresa el correo</h2></label>
                    <input type="email" id="email" class="fontinput" name="email" placeholder="Ingresa tu correo" required>
                </div>
            </div>
            <br>
            <button type="submit" class="botoningre">Continuar</button>
        </form>
        </div>
    </main>
</div>

        <footer class="pie">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
            <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
            <a href="{{ route('redes') }}" class="abaj">Redes</a>
            <br>
            <br>
            <p>&copy; 2024 - GUT KLEID.</p>
        </footer>

</body>

</html>