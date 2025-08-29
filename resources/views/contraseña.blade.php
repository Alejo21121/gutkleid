<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/STYLE LOGIN.css">
    <link rel="icon" href="IMG/icono.ico" class="imagenl" type="image/x-icon">
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ url()->previous() }}">
                    <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
                </a>
                <a href="{{ route('reseñas') }}"><button class="filter-btn">Acerca de</button></a>
            </div>
            <div class="logo">
                <a href="/">
                    <img src="IMG/LOGO3.PNG" alt="Logo">
                </a>
            </div>
            <div class="barra2">
                <a href="{{ route('login') }}"><button class="filter-btn">Iniciar sesión</button></a>
                <div class="iconos">
                    <a href="CARRITO DE COMPRAS.html"><button class="filter-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg></button></a>
                </div>
            </div>
        </nav>
    </header>
</head>

<body>
    <div class="form-container">
        <form action="{{ route('validar.codigo') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="codigo">Escribe el código de recuperación:</label>
                <input type="text" id="codigo" name="codigo" placeholder="Ingresa el código" required>
                @error('codigo')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="position: relative;">
                <label for="nueva-password">Nueva contraseña:</label>
                <input type="password" id="nueva-password" name="nueva-password" placeholder="Ingresa la nueva contraseña" required>
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
                <input type="password" id="nueva-password_confirmation" name="nueva-password_confirmation" placeholder="Repite la nueva contraseña" required>
                <button type="button" onclick="togglePassword('nueva-password_confirmation', 'icono2')"
                    style="position: absolute; right: 10px; top: 40px; background: none; border: none;">
                    <i id="icono2" class="bi bi-eye-slash"></i>
                </button>
            </div>

            <button type="submit" class="filter-bcc">Entrar</button>
        </form>
    </div>

</body>
<footer class="pie">
    <div class="foot">
        <br>
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        <center>
            <h6>&copy; 2024 - GUT KLEID.</h6>
        </center>
    </div>
</footer>

</html>

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