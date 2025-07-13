<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gut Kleid</title>
  <link rel="stylesheet" href="CSS/ACERCA DE.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
  <link rel="icon" href="IMG/icono2.ico" class="imagenl" type="image/x-icon">
  <header class="cabeza">
    <nav class="barras">
      <div class="barra1">
        <a href="{{ url()->previous() }}">
          <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
        </a>
        <a href="{{ route('reseñas') }}"><button class="filter-btn">Acerca de</button></a>
        @if (session('usuario') && session('usuario')['id_rol'] == 1)
        <a class="filter-btn" href="{{ route('producto.index') }}">Panel</a>
        @endif
      </div>
      <div class="logo">
        <a href="/"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
      </div>
      <div class="barra2">
        <div class="usuario-info">
          @if (session('usuario'))
          <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
          @if (session('usuario'))
          <a href="{{ route('cuenta') }}">
            <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
              alt="Perfil" class="perfil-icono">
          </a>
          @endif
          <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
          @else
          <a href="{{ route('login') }}" class="inis">
            <p class="filter-btna">Inicia sesión</p>
          </a>
          @endif
          <div class="iconos">
            <a href="{{ route('carrito.index') }}"><button class="filter-btn"><i class="bi bi-cart3"></i></button></a>
          </div>
        </div>
      </div>
    </nav>
  </header>
</head>

<body>
  <div class="container">
    <div class="datos-usuario-container">
      <center>
        <h1 class="mb-4">Tu Dirección</h1>
      </center>

      <div class="mb-3">
        <strong>Nombres:</strong> {{ session('usuario')['nombres'] ?? '' }}
      </div>

      <div class="mb-3">
        <strong>Apellidos:</strong> {{ session('usuario')['apellidos'] ?? '' }}
      </div>

      <div class="mb-3">
        <strong>Número de documento:</strong> {{ session('usuario')['documento'] ?? '' }}
      </div>

      <div class="mb-3">
        <strong>Teléfono:</strong> {{ session('usuario')['telefono'] ?? '' }}
      </div>

      <form method="POST" action="{{ route('perfil.actualizar_direccion') }}">
        @csrf
        <div class="mb-3">
          <label for="direccion" class="form-label"><strong>Dirección:</strong></label>
          <input type="text" class="form-control" id="direccion" name="direccion"
            value="{{ session('usuario')['direccion'] }}" required>
            
        </div>

        <div class="mb-3">
          <label for="info_adicional" class="form-label"><strong>Información adicional:</strong></label>
          <textarea class="form-control" id="info_adicional" name="info_adicional" rows="3">{{ session('usuario')['info_adicional'] ?? '' }}</textarea>
        </div>

        <center><button type="submit" class="filter-bcc">Guardar cambios</button></center>
      </form>

    </div>
  </div>

</body>
<footer class="pie">
  <div class="foot">
    <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
    <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
  </div>
  <p>&copy; 2024 - GUT KLEID.</p>
</footer>

</html>