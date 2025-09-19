<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="CSS/STYLE LOGIN.css">
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
      <h2>Inicio de Sesión</h2>

      <!-- Mensaje de error -->
      @if (session('error'))
        <div class="alert alert-danger text-center">
          {{ session('error') }}
        </div>
      @endif

      <!-- Formulario -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" id="username" name="username" required placeholder="Ingrese su correo" class="fontinput">

        <div class="password-container" style="display:flex; align-items:center; justify-content:center; gap:10px;">
          <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña" class="fontinput">
                <button type="button" onclick="togglePassword('contraseña_confirmation', 'iconoConfirmacion')" 
                    style="position: absolute; right: 50px; top: 162px; background: none; border: none;">
                    <i id="iconoConfirmacion" class="bi bi-eye-slash"></i>
                </button>
        </div>

        <button type="submit" class="botoningre">Ingresar</button>
      </form>

      <!-- Links -->
      <a href="{{ route('correo_cliente') }}" class="recuper">Recuperar contraseña</a>
      <a href="{{ route('registro.form') }}" class="register">Registrarse</a>
    </div>
  </main>

  <!-- Script mostrar/ocultar contraseña -->
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