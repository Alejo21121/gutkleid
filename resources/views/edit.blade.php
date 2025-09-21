<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/usuredit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="IMG/icono2.ico" type="image/x-icon">
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <!-- CENTRO -->
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
    <main class="main">
    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div class="mensaje éxito">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('usuarios.update', $usuario->id_persona) }}" method="POST" class="formedit">
    @csrf
    @method('PUT')

    <h2 class="text-center mb-4">Editar Usuario</h2>

    <div class="mb-3 row">
        <label for="documento" class="col-sm-3 col-form-label">Documento:</label>
        <div class="col-sm-9">
            <input type="text" name="documento" id="documento" value="{{ old('documento', $usuario->documento) }}" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="id_tipo_documento" class="col-sm-3 col-form-label">Tipo de documento:</label>
        <div class="col-sm-9">
            <select name="id_tipo_documento" id="id_tipo_documento" class="form-select" required>
                <option value="">Selecciona tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_documento }}" {{ $tipo->id_tipo_documento == $usuario->id_tipo_documento ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="nombres" class="col-sm-3 col-form-label">Nombres:</label>
        <div class="col-sm-9">
            <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $usuario->nombres) }}" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="apellidos" class="col-sm-3 col-form-label">Apellidos:</label>
        <div class="col-sm-9">
            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="telefono" class="col-sm-3 col-form-label">Teléfono:</label>
        <div class="col-sm-9">
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="correo" class="col-sm-3 col-form-label">Correo:</label>
        <div class="col-sm-9">
            <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo) }}" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="contraseña" class="col-sm-3 col-form-label">Contraseña:</label>
        <div class="col-sm-9 d-flex">
            <input type="password" id="contraseña" name="contraseña" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary ms-2" onclick="togglePassword('contraseña', 'iconoContraseña')">
                <i id="iconoContraseña" class="bi bi-eye-slash"></i>
            </button>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="direccion" class="col-sm-3 col-form-label">Dirección:</label>
        <div class="col-sm-9">
            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $usuario->direccion) }}" class="form-control" required>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="botoningre">Actualizar Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="volve">Volver</a>
    </div>
</form>
</main>
<br>
    <footer class="pie">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
        <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
        <a href="{{ route('redes') }}" class="abaj">Redes</a>
        <br><br>
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
