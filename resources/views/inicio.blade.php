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
                    <a href="{{ route('carrito.index') }}"><button class="filter-btn"><i class="bi bi-cart3"></i></button></a>
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
            ['id' => 1, 'img1' => 'buso sc.jpg', 'img2' => 'buzo sc2.webp', 'img3' => 'buzo sc3.webp', 'nombre' => 'Buzo', 'precio' => 64999],
            ['id' => 2, 'img1' => 'jeanm1.webp', 'img2' => 'jeanm3.webp', 'img3' => 'jeanm2.webp', 'nombre' => 'Jean', 'precio' => 59999],
            ['id' => 3, 'img1' => 'chaqueta jeanh.jpg', 'img2' => 'chaqueta jeanh2.webp', 'img3' => 'chaqueta jean3.webp', 'nombre' => 'Chaqueta Jean', 'precio' => 99999],
            ['id' => 4, 'img1' => 'buzom1.webp', 'img2' => 'buzom2.webp', 'img3' => 'buzom3.webp', 'nombre' => 'Buzo Capotero', 'precio' => 44999],
            ['id' => 5, 'img1' => 'chaquetapff1.webp', 'img2' => 'chaquetapff2.webp', 'img3' => 'chaquetapff3.webp', 'nombre' => 'Chaqueta', 'precio' => 44999],
            ['id' => 6, 'img1' => 'jeanh1.webp', 'img2' => 'jeanh2.jpg', 'img3' => 'jeanh3.webp', 'nombre' => 'Jean', 'precio' => 64999],
            ['id' => 7, 'img1' => 'gorra.jpg', 'img2' => 'gorram2.webp', 'img3' => 'gorram3.webp', 'nombre' => 'Gorra', 'precio' => 24999]
        ] as $producto)
        <div class="productos">
            <div class="mini-carousel">
                <div class="mini-carousel-images">
                    <img src="IMG/{{ $producto['img1'] }}" class="mini-slide active">
                    <img src="IMG/{{ $producto['img2'] }}" class="mini-slide">
                    <img src="IMG/{{ $producto['img3'] }}" class="mini-slide">
                </div>
                <button class="prev" onclick="moverSlide(-1)">&#10094;</button>
                <button class="next" onclick="moverSlide(1)">&#10095;</button>
            </div>
            <br>
            <h5>{{ $producto['nombre'] }}</h5>
            <p>${{ number_format($producto['precio'], 0, ',', '.') }} COP</p>

            <form action="{{ route('carrito.agregar') }}" method="POST" onsubmit="agregado(event)">
                @csrf
                <input type="hidden" name="id_producto" value="{{ $producto['id'] }}">
                <input type="hidden" name="nombre" value="{{ $producto['nombre'] }}">
                <input type="hidden" name="precio" value="{{ $producto['precio'] }}">
                <input type="hidden" name="imagen" value="{{ $producto['img1'] }}">
                <button type="submit" class="bottonagreg">
                    Agregar al carrito
                </button>
            </form>
        </div>
        @endforeach
    </div>
</main>

<!-- Toast de éxito -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="toastAgregado" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                ✅ Producto agregado al carrito con éxito.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    </div>
</div>

<script>
    function agregado(event) {
        event.preventDefault();
        const form = event.target;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(new FormData(form))
        }).then(response => {
            if (response.ok) {
                const toastEl = document.getElementById('toastAgregado');
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        }).catch(error => {
            alert('❌ Error al agregar el producto.');
        });
    }
</script>

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