<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Gut Kleid</title>
    <link rel="stylesheet" href="CSS/REGISTRO USUARIO.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="IMG/icono2.ico" type="image/x-icon">
</head>
<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ url()->previous() }}">
                    <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
                </a>
                <button class="filter-btn">Acerca de</button>
            </div>
            <div class="logo">
        <div class="logo">
            <a href="/"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
        </div>
                <div class="barra2">
                    <a href="INICIO DE SESION.php"><button class="filter-btn">Iniciar sesión</button></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h1 class="text-center mb-4">Regístrate</h1>

        <form method="POST" action="{{ route('registro.enviar') }}" class="text-center">
            @csrf

            <input type="text" name="documento" placeholder="Documento de identidad" required value="{{ old('documento') }}"><br>
            @error('documento') <div style="color:red;">{{ $message }}</div> @enderror

           <select name="id_tipo_documento" required>
                <option value="">Tipo de documento</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_documento }}" {{ old('id_tipo_documento') == $tipo->id_tipo_documento ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select><br>
            @error('id_tipo_documento') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="nombres" placeholder="Nombres" required value="{{ old('nombres') }}"><br>
            @error('nombres') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="apellidos" placeholder="Apellidos" required value="{{ old('apellidos') }}"><br>
            @error('apellidos') <div style="color:red;">{{ $message }}</div> @enderror

           <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" required value="{{ old('fecha_nacimiento') }}">
                @error('fecha_nacimiento') <div style="color:red;">{{ $message }}</div> @enderror
            </div>

            <input type="text" name="direccion" placeholder="Dirección" required value="{{ old('direccion') }}"><br>
            @error('direccion') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="text" name="telefono" placeholder="Teléfono" required value="{{ old('telefono') }}"><br>
            @error('telefono') <div style="color:red;">{{ $message }}</div> @enderror

            <input type="email" name="correo" placeholder="Correo Electrónico" required value="{{ old('correo') }}"><br>
            @error('correo') <div style="color:red;">{{ $message }}</div> @enderror

            <div style="position: relative;">
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                <button type="button" onclick="togglePassword('contraseña', 'iconoContraseña')" 
                    style="position: absolute; right: 55px; top: 20px; background: none; border: none;">
                    <i id="iconoContraseña" class="bi bi-eye-slash"></i>
                </button>
            </div>
            @error('contraseña') <div style="color:red;">{{ $message }}</div> @enderror

            <div style="position: relative;">
                <input type="password" id="contraseña_confirmation" name="contraseña_confirmation" placeholder="Confirmar Contraseña" required>
                <button type="button" onclick="togglePassword('contraseña_confirmation', 'iconoConfirmacion')" 
                    style="position: absolute; right: 55px; top: 20px; background: none; border: none;">
                    <i id="iconoConfirmacion" class="bi bi-eye-slash"></i>
                </button>
            </div>

            <button type="submit" class="filter-bcc mt-3">Registrarse</button>
        </form>
    </main>

    <footer class="pie mt-5">
        <div class="foot">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        </div>
        <p class="text-center">&copy; 2024 - GUT KLEID.</p>
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


