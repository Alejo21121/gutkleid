<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid - Editar Usuario</title>
    <link rel="stylesheet" href="{{ asset('CSS/estiloagre.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>

<div class="container">
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

    <form action="{{ route('usuarios.update', $usuario->id_persona) }}" method="POST">
        @csrf
        @method('PUT') {{-- Importante para indicar que es una solicitud de actualización --}}

        <center><h2>Editar Usuario</h2></center>

        {{-- Documento --}}
        <div class="mb-3">
            <label for="documento" class="form-label">Documento:</label>
            <input type="text" name="documento" id="documento" value="{{ old('documento', $usuario->documento) }}" class="form-control" required>
            @error('documento')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tipo de Documento --}}
        <div class="mb-3">
                    <label for="id_tipo_documento">Tipo de documento:</label>
            <select name="id_tipo_documento" id="id_tipo_documento" required>
                <option value="">Selecciona tipo de documento</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_documento }}" {{ old('id_tipo_documento') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nombres --}}
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres:</label>
            <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $usuario->nombres) }}" class="form-control" required>
            @error('nombres')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Apellidos --}}
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" class="form-control" required>
            @error('apellidos')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="form-control" required>
            @error('telefono')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Correo --}}
        <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo) }}" class="form-control" required>
            @error('correo')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Contraseña (opcional para edición) --}}
        <div class="mb-3" style="position: relative;">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Dejar en blanco para no cambiar" style="padding-right: 40px;">
            
            <button type="button" class="boton-ojo2" onclick="togglePassword('contraseña', 'iconoEditarContraseña')"
            style="bottom: -20px;">
                <i id="iconoEditarContraseña" class="bi bi-eye-slash"></i>
            </button>

            @error('contraseña')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        {{-- Dirección --}}
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $usuario->direccion) }}" class="form-control" required>
            @error('direccion')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Actualizar Usuario</button>
        <center><a href="{{ route('usuarios.index') }}" class="btn-menu">Volver a Gestión de Usuarios</a></center>
    </form>
</div>
<br>
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
