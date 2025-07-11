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
                    @if (session('usuario'))
                        <a href="{{ route('cuenta') }}">
                            <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                                alt="Perfil"
                                class="perfil-icono">
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

<div class="contenedor">
    <input type="text" id="search" placeholder="Buscar" class="busca">
    <a href="#"><button class="botonbusca"><i class="bi bi-search"></i></button></a>
</div>

<main class="main">
    <br>
    <div class="productosbar">
        @foreach ($productos as $producto)
            @php
                $precioConIVA = round($producto->valor * (1 + $producto->iva));
            @endphp
            <div class="productos">
                <a href="{{ route('producto.ver', $producto->id_producto) }}" class="producto-link" style="text-decoration: none; color: inherit;">
                    <div class="mini-carousel" onclick="event.stopPropagation();">
                        <div class="mini-carousel-images">
                            @foreach ($producto->imagenes as $imagen)
                                <img src="{{ asset($imagen->ruta) }}" class="mini-slide {{ $loop->first ? 'active' : '' }}">
                            @endforeach
                        </div>
                        <button type="button" class="prev" onclick="moverSlide(event, -1)">&#10094;</button>
                        <button type="button" class="next" onclick="moverSlide(event, 1)">&#10095;</button>
                    </div>
                    <br>
                    <h5>{{ $producto->nombre }}</h5>
                    <p><strong>${{ number_format($precioConIVA, 0, ',', '.') }} COP</strong></p>
                </a>

                <a href="{{ route('producto.ver', $producto->id_producto) }}">
                    <button type="button" class="bottonagreg">Ver más</button>
                </a>
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

    function moverSlide(event, direccion) {
    event.preventDefault();
    event.stopPropagation(); // <-- Esto evita que se dispare el enlace

    const carousel = event.target.closest('.mini-carousel');
    const slides = carousel.querySelectorAll('.mini-slide');
    let index = Array.from(slides).findIndex(s => s.classList.contains('active'));

    slides[index].classList.remove('active');
    index = (index + direccion + slides.length) % slides.length;
    slides[index].classList.add('active');
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
