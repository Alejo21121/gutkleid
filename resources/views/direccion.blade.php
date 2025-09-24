<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/DIRECCION.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>

<body id="my-account" class="page-my-account">

    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <!-- IZQUIERDA -->
                <div class="nav-left">
                    @if (session('usuario') && session('usuario')['id_rol'] == 1)
                    <a class="filter-btn" href="{{ route('producto.index') }}">PANEL</a>
                    @endif
                </div>
            </div>

            <!-- CENTRO -->
            <div class="nav-center">
                <div class="logo">
                    <a href="/">
                        <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                    </a>
                </div>
            </div>

            <!-- DERECHA -->
            <div class="nav-right">
                <div class="usuario-info">
                    @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil"
                            class="perfil-icono">
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
        <br><br>
<center>
        <main class="main">
  <div class="contenedor">
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

        <center><button type="submit" class="botoningre">Guardar cambios</button></center>
      </form>
    </div>
  </div>
</main>
    <footer class="pie">
        <strong><a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a></strong>
        <strong><a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a></strong>
        <strong><a href="{{ route('reseñas') }}" class="abaj">Reseñas</a></strong>
        <strong><a href="{{ route('tiendas') }}" class="abaj">Tiendas</a></strong>
        <strong><a href="{{ route('redes') }}" class="abaj">Redes</a></strong>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>
</body>

</html>