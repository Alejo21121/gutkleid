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
            </div>
            <div class="logo">
            <div class="iconos">
                <a href="/">
                    <img class="logo1" src="IMG/LOGO3.PNG" alt="Logo">
                </a>
            </div>
            <div class="barra2">
                <div class="usuario-info">
                    @if (session('usuario'))
                        <a href="{{ url('/logout') }}">
                            <button class="filter-btn">Cerrar sesión</button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="filter-btn">Inicia sesión</button>
                        </a>
                    @endif
                </div>
                <div class="iconos">
                    <a href="CARRITO DE COMPRAS.html"><button class="filter-btn"><i class="bi bi-cart3"></i></button></a>
                    @if (session('usuario'))
                        <a href="{{ route('cuenta') }}"><button class="filter-btn"><i class="bi bi-person-fill"></i> Mi cuenta </button></a>
                    @endif
                </div>
            </div>
        </nav>
    </header>
</head>
<body>
    <div class="container">
        <div class="reseña-containe">
          <div class="reviews">
            <h1>Reseñas</h1>
            <div class="review">
              <span class="icon">👤</span>
              <p>Me encanta la calidad y frescura</p>
            </div>
            <div class="review">
              <span class="icon">👤</span>
              <p>Envío rápido y total confianza</p>
            </div>
            <div class="review">
              <span class="icon">👤</span>
              <p>Llegó en la fecha estipulada y la talla justa</p>
            </div>
            <div class="review">
              <span class="icon">👤</span>
              <p>Calidad Precio en todo el sentido</p>
            </div>
          </div>
        </div>
      </div>
        <div>
          <center>
            <a href="{{ route('redes') }}"><button class="filter-bcc">Redes</button></a>
            <a href="{{ route('tiendas') }}"><button class="filter-bcc">Tiendas</button></a>
            <a href="#"><button class="filter-bccselect">Reseñas</button></a>
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
