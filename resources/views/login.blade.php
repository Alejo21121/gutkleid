<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gut Kleid - Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('CSS/INICIO DE SESION CLIENTE.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <div class="barra1">
            <a href="{{ url()->previous() }}">
                <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
            </a>
            <a href="RESEÑAS.html"><button class="filter-btn">Acerca de</button></a>
        </div>

        <div class="logo">
            <a href="/"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
        </div>

        <div class="barra2"></div> <!-- Este sirve para que el logo quede en el centro real -->
    </nav>
</header>
<main class="container mt-5">
    <h2 class="text-center">Inicio de Sesión</h2>

    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

   <form method="POST" action="{{ route('login') }}" class="text-center">
        @csrf
        <label for="username">Correo:</label>
        <input type="email" id="username" name="username" required placeholder="Ingrese su correo"><br>

        <label for="password">Contraseña:</label>
        <div style="position: relative;">
            <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">
            <button type="button" onclick="togglePassword()" 
                    style="position: absolute; right: 20px; top: 10px; background: none; border: none; cursor: pointer;">
                <i id="togglePasswordIcon" class="bi bi-eye-slash"></i>
            </button>
        </div><br>

        <button type="submit" class="filter-bcc">Ingresar</button>
    </form>


    <div class="mt-3 text-center">
        <a href="{{ route('correo_cliente') }}" class="recuper">Recuperar contraseña</a> 
        <a href="{{ route('registro.form') }}" class="register">Registrarse</a>
    </div>
</main>

<footer class="pie mt-5">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        <center><h6>&copy; 2024 - GUT KLEID.</h6></center>
    </div>
</footer>
</body>
</html>

<script>

function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");

    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";

    // Cambia el ícono
    icon.classList.toggle("bi-eye-slash");
    icon.classList.toggle("bi-eye");
}
</script>

