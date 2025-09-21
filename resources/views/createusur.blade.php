<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/usuariocreation.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="IMG/icono2.ico" type="image/x-icon">
</head>
<body>

<header class="cabeza">
    <nav class="barras">
        <!-- LOGO CENTRADO -->
        <div class="nav-center">
            <a href="/">
                <div class="logo">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                </div>
            </a>
        </div>

        <!-- DERECHA -->
        <div class="nav-right">
            <div class="usuario-info">
                @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil" class="perfil-icono">
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
        </div>
    </nav>
    <hr>
</header>

<main class="main">
    <!-- ALERTA DE ÉXITO -->
    @if (session('success'))
        <div class="alerta-exito">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- FORMULARIO -->
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <h2 class="mb-3">Agregar Usuario</h2>

        <div class="form-group">
            <label for="documento">Documento:</label>
            <input type="text" name="documento" id="documento" value="{{ old('documento') }}" required>
            @error('documento') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="id_tipo_documento">Tipo de documento:</label>
            <select name="id_tipo_documento" id="id_tipo_documento" required>
                <option value="">Selecciona tipo de documento</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_documento }}" {{ old('id_tipo_documento') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_tipo_documento') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="nombres">Nombres:</label>
            <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" required>
            @error('nombres') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required>
            @error('apellidos') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required>
            @error('telefono') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required>
            @error('correo') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="contraseña">Contraseña:</label>
            <div class="grupo-contraseña">
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                <button type="button" class="boton-ojo" onclick="togglePassword('contraseña', 'iconoContraseña')">
                    <i id="iconoContraseña" class="bi bi-eye-slash"></i>
                </button>
            </div>
            @error('contraseña') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}" required>
            @error('direccion') <div class="error-msg">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="botoningre">Agregar Usuario</button>
            <a href="{{ route('usuarios.index') }}" class="volve">Volver a Gestión de Usuarios</a>
        </div>
    </form>
</main>

<footer class="pie">
    <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
    <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
    <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
    <a href="{{ route('redes') }}" class="abaj">Redes</a>
    <br><br>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

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

</body>
</html>
