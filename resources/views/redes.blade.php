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
                    <a href="{{ route('login') }}" class="inis"><p class="filter-btna">Inicia sesión</p></a>
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
    <div class="">
      <center><h1>Redes Sociales</h1></center>
      <br>
      <div class="redes-grid">
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/facebook.png" alt=""></button></a>
        </div>
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/instagram.png" alt=""></button></a>
        </div>
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/twitter.png" alt=""></button></a>
        </div>
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/whatsapp.png" alt=""></button></a>
        </div>
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/google.png" alt=""></button></a>
        </div>
        <div class="redsocial">
          <a href="#"><button class="redsocial"><img src="IMG/tik tok.png" alt=""></button></a>
        </div>
      </div>
    </div>
  </div>
    <div>
      <center>
      <a href="#"><button class="filter-bccselect">Redes</button></a>
      <a href="{{ route('tiendas') }}"><button class="filter-bcc">Tiendas</button></a>
      <a href="{{ route('reseñas') }}"><button class="filter-bcc">Reseñas</button></a>
    </center>
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