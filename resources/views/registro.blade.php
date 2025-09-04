<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="CSS/REGISTRO USUARIO.css">
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
      <h2>Registrate</h2>

        <form method="POST" action="{{ route('registro.enviar') }}" class="text-center">
            @csrf

            <input type="text" name="documento" class="fontinput" placeholder="Documento de identidad" required value="{{ old('documento') }}"><br>
            @error('documento') <div style="color:red;">{{ $message }}</div> @enderror

           <select name="id_tipo_documento" class="fontinput" required class="menuin">
                <option value="">Tipo de documento</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_documento }}" {{ old('id_tipo_documento') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select><br>
            @error('id_tipo_documento') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="nombres" placeholder="Nombres" class="fontinput" required value="{{ old('nombres') }}"><br>
            @error('nombres') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="apellidos" class="fontinput" placeholder="Apellidos" required value="{{ old('apellidos') }}"><br>
            @error('apellidos') <div style="color:red;">{{ $message }}</div> @enderror

           <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="fontinput" required value="{{ old('fecha_nacimiento') }}">
                @error('fecha_nacimiento') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <input type="text" name="direccion" class="fontinput" placeholder="Dirección" required value="{{ old('direccion') }}"><br>
            @error('direccion') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="telefono" class="fontinput" placeholder="Teléfono" required value="{{ old('telefono') }}"><br>
            @error('telefono') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="email" name="correo" class="fontinput" placeholder="Correo Electrónico" required value="{{ old('correo') }}"><br>
            @error('correo') <div style="color:red;">{{ $message }}</div> @enderror

            <div style="position: relative;">
                <input type="password" id="contraseña" name="contraseña" class="fontinput" placeholder="Contraseña" required>
                <button type="button" onclick="togglePassword('contraseña', 'iconoContraseña')" 
                    style="position: absolute; right: 20px; top: 13px; background: none; border: none;">
                    <i id="iconoContraseña" class="bi bi-eye-slash"></i>
                </button>
            </div>
            @error('contraseña') <div style="color:red;">{{ $message }}</div> @enderror

            <div style="position: relative;">
                <input type="password" id="contraseña_confirmation" class="fontinput" name="contraseña_confirmation" placeholder="Confirmar Contraseña" required>
                <button type="button" onclick="togglePassword('contraseña_confirmation', 'iconoConfirmacion')" 
                    style="position: absolute; right: 20px; top: 13px; background: none; border: none;">
                    <i id="iconoConfirmacion" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="botoningre">Registrarse</button>
        </form>
    </main>
    </main>
<footer class="pie">
    <a href="{{ route('terminos') }}" class="abaj">Terminos y Condiciones</a>
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


