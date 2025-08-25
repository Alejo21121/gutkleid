<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="CSS/ACERCA DE.css">
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

        <!-- DERECHA -->
        <div class="nav-right">
            <div class="usuario-info">
                @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                             alt="Perfil"
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
  <div class="main">
    <main class="tiendass">
      <center><h1>Tiendas</h1>
      <div class="store-locations">
        <div class="location">
          <p>Ubicación 1<br><a href="https://www.google.com/maps">Calle 120e #62d-27 Norte</a></p>
        </div>
        <div>
          <p>Ubicación2<br><a href="https://www.google.com/maps">Carrera 81i #73f-63 Sur</a></p>
        </div>
        <div>
          <p>Ubicación3 <br><a href="https://www.google.com/maps">Avenida 73b #83f-23 Occidente</a></p>
        </div>
        </div></center>
        </main>
  </div>
</body>
<footer class="pie">
      <a href="{{ route('terminos') }}" class="abaj">Terminos y Condiciones</a>
    <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
    <a href="{{ route('redes') }}" class="abaj">Redes</a>
    <br>
    <br>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>
</html>