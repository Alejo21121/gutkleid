<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid - Agregar Usuario</title>
    <link rel="stylesheet" href="{{ asset('CSS/estiloagre.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>

@if (session('success'))
    <div class="mensaje éxito">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf
    <h2>Agregar Usuario</h2>

    <label for="id_persona">ID Persona:</label>
    <input type="number" name="id_persona" id="id_persona" required value="{{ old('id_persona') }}">
    @error('id_persona')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="documento">Documento:</label>
    <input type="text" name="documento" id="documento" required value="{{ old('documento') }}">
    @error('documento')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <label for="id_tipo_documento">Tipo de documento:</label>
    <select name="id_tipo_documento" id="id_tipo_documento" required>
        <option value="">Selecciona tipo de documento</option>
        @foreach ($tipos as $tipo)
            <option value="{{ $tipo->id_tipo_documento }}" {{ old('id_tipo_documento') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                {{ $tipo->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_tipo_documento') 
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="nombres">Nombres:</label>
    <input type="text" name="nombres" id="nombres" required value="{{ old('nombres') }}">
    @error('nombres')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="apellidos">Apellidos:</label>
    <input type="text" name="apellidos" id="apellidos" required value="{{ old('apellidos') }}">
    @error('apellidos')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" id="telefono" required value="{{ old('telefono') }}">
    @error('telefono')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="correo">Correo:</label>
    <input type="email" name="correo" id="correo" required value="{{ old('correo') }}">
    @error('correo')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="password">Contraseña:</label>
    <input type="password" name="contraseña" id="contraseña" required>
    @error('contraseña')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label for="direccion">Dirección:</label>
    <input type="text" name="direccion" id="direccion" required value="{{ old('direccion') }}">
    @error('direccion')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    {{-- ELIMINADO: Campo 'id_rol' --}}

    <button type="submit">Agregar Usuario</button>
    <center><a href="{{ route('usuarios.index') }}" class="btn-menu">Volver a Gestión de Usuarios</a></center>
</form>
<br>
</body>
</html>