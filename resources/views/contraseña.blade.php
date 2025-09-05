<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="CSS/CODIGO RECUPERACION.css">
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
      <!-- MAIN con imagen de fondo -->
  <main class="main">
    <!-- Caja de login -->
    <div class="container-login">

        {{-- Mensajes globales --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('validar.codigo') }}" method="POST">
            @csrf
            <div class="form-group">
                <h2>Código De Recuperación:</h2>
                <input type="text" id="codigo" name="codigo" class="fontinput" placeholder="Ingresa el código" required>
                @error('codigo')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="position: relative;">
                <label for="nueva-password">Nueva contraseña:</label>
                <input type="password" id="nueva-password" name="nueva-password" class="fontinput" placeholder="Ingresa la nueva contraseña" required>
                <button type="button" onclick="togglePassword('nueva-password', 'icono1')"
                    style="position: absolute; right: 10px; top: 40px; background: none; border: none;">
                    <i id="icono1" class="bi bi-eye-slash"></i>
                </button>
                @error('nueva-password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="position: relative;">
                <label for="nueva-password_confirmation">Repite la contraseña:</label>
                <input type="password" id="nueva-password_confirmation" name="nueva-password_confirmation" class="fontinput" placeholder="Repite la nueva contraseña" required>
                <button type="button" onclick="togglePassword('nueva-password_confirmation', 'icono2')"
                    style="position: absolute; right: 10px; top: 40px; background: none; border: none;">
                    <i id="icono2" class="bi bi-eye-slash"></i>
                </button>
            </div>

            <button type="submit" class="botoningre">Entrar</button>
        </form>
    </div>
</main>
<script>
    function togglePassword(idCampo, idIcono) {
        const input = document.getElementById(idCampo);
        const icono = document.getElementById(idIcono);

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        icono.classList.toggle('bi-eye');
        icono.classList.toggle('bi-eye-slash');
    }
</script>
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
