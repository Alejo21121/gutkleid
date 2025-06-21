<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/PAGINA PRINCIPAL.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>
<header class="cabeza">
    <nav class="barras">
        <div class="barra1">
            <a href="{{ route('reseñas') }}"><button class="filter-btn">Acerca de</button></a>
            @if (session('usuario') && session('usuario')['id_rol'] == 1)
                <a class="filter-btn" href="{{ route('producto.index') }}">Panel</a>
            @endif
        </div>
        <div class="logo">
            <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
        </div>
        <div class="barra2">
            <div class="usuario-info">
                @if (session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
                @else
                    <a href="{{ route('login') }}" class="inis"><p class="filter-btna">Inicia sesión</p></a>
                @endif
                <div class="iconos">
                <a href="CARRITO DE COMPRAS.html"><button class="filter-btn"><i class="bi bi-cart3"></i></button></a>
                @if (session('usuario'))
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                            alt="Perfil"
                            class="perfil-icono">
                    </a>
                @endif
                </div>
            </div> 
        </div>
    </nav>
</header>
            <div class="contenedor">
            <input type="text" id="search" placeholder="Buscar" class="busca">
            <a href="#">
            <button class="botonbusca">
                <i class="bi bi-search"></i>
            </button>
            </a>
            </div>
<main class="main">
    <br>
    <div class="productosbar">
        @foreach ([
            ['buso sc.jpg', 'buzo sc2.webp', 'buzo sc3.webp', 'Buzo', '64,999'],
            ['jeanm1.webp', 'jeanm3.webp', 'jeanm2.webp', 'Jean', '59,999'],
            ['chaqueta jeanh.jpg', 'chaqueta jeanh2.webp', 'chaqueta jean3.webp', 'Chaqueta Jean', '99,999'],
            ['buzom1.webp', 'buzom2.webp', 'buzom3.webp', 'Buzo Capotero', '44,999'],
            ['chaquetapff1.webp', 'chaquetapff2.webp', 'chaquetapff3.webp', 'Chaqueta', '44,999'],
            ['jeanh1.webp', 'jeanh2.jpg', 'jeanh3.webp', 'Jean', '64,999'],
            ['gorra.jpg', 'gorram2.webp', 'gorram3.webp', 'Gorra', '24,999']
        ] as [$img1, $img2, $img3, $nombre, $precio])
        <div class="productos">
            <div class="mini-carousel">
                <div class="mini-carousel-images">
                    <a href="VISTA PRODUCTO.html">
                        <img src="IMG/{{ $img1 }}" class="mini-slide active">
                        <img src="IMG/{{ $img2 }}" class="mini-slide">
                        <img src="IMG/{{ $img3 }}" class="mini-slide">
                    </a>
                </div>
                <button class="prev" onclick="moverSlide(-1)">&#10094;</button>
                <button class="next" onclick="moverSlide(1)">&#10095;</button>
            </div>
            <br>
            <h5>{{ $nombre }}</h5>
            <p>{{ $precio }} COP</p>
            <a href="VISTA PRODUCTO.html"><button class="btn btn-success">Ver más</button></a>
        </div>
        @endforeach
    </div>
</main>

<script src="{{ asset('JS/script.js') }}"></script>
<script src="{{ asset('JS/script2.js') }}"></script>
<script src="{{ asset('JS/navbar.js') }}"></script>

<footer class="pie">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

</body>
</html>