<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/VISTA PRODUCTO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>

    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
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
                    </div>
                </a>
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
            </div>
        </nav>
        <hr>
        <main class="main">
            <div class="container-login">
                <div class="producto-galeria">
                    <!-- Imagen grande -->
                    <div class="imagen-principal">
                        <img id="imagenGrande" src="{{ asset($producto->imagenes->first()->ruta ?? 'IMG/default.jpg') }}" alt="Imagen principal">
                    </div>

                    <!-- Miniaturas -->
                    <div class="miniaturas">
                        @foreach ($producto->imagenes as $img)
                        <img class="miniatura" src="{{ asset($img->ruta) }}" alt="Miniatura" onclick="cambiarImagen('{{ asset($img->ruta) }}')">
                        @endforeach
                    </div>
                </div>

                <!-- Botón flotante de WhatsApp -->
                <a href="https://wa.me/573042255701"
                    class="btn-whatsapp" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp">
                </a>


                <div class="producto-info">
                    <h2>{{ $producto->nombre }}</h2>

                    @php
                    $valor = $producto->valor;
                    $iva = $valor * 0.19; // o $producto->iva si tienes ese campo
                    $precioFinal = round($valor + $iva, -3); // redondea a mil
                    @endphp

                    <p class="price">${{ number_format($precioFinal, 0, ',', '.') }} COP</p>
                    <p>Color: {{ $producto->color }}</p>
                    <p>Marca: {{ $producto->marca }}</p>

                    <!-- Reemplaza TODO tu producto_ver.blade.php por esto -->

                    <form action="{{ route('carrito.agregar') }}" method="POST" onsubmit="agregado(event)">

                        @csrf
                        <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                        <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                        <input type="hidden" name="precio" value="{{ $producto->valor }}">
                        <input type="hidden" name="talla" id="inputTalla">
                        <input type="hidden" name="color" id="inputColor" value="{{ $producto->color }}">
                        <input type="hidden" name="cantidad" id="cantidadInput" value="1">

                        <div class="cantidad-selector" style="margin: 10px 0; display: flex; align-items: center; gap: 10px;">
                            <button type="button" onclick="cambiarCantidad(-1)" class="bottoncantimen">-</button>
                            <span id="cantidadVisible" style="min-width: 30px; text-align: center;">1</span>
                            <button type="button" onclick="cambiarCantidad(1)" class="bottoncantimas">+</button>
                        </div>

                        @php
                        // Traducción de color en español (base de datos) → nombre de color válido en CSS
                        $coloresCSS = [
                        'Blanco' => 'white',
                        'Negro' => 'black',
                        'Marrón' => 'brown',
                        'Azul' => 'blue',
                        'Rojo' => 'red',
                        'Gris' => 'gray',
                        'Amarillo' => 'yellow',
                        'Verde' => 'Green',
                        'Beige' => 'beige'
                        // agrega más si los tienes
                        ];

                        $colorCSS = $coloresCSS[$producto->color] ?? 'gray'; // color por defecto si no está en el arreglo
                        @endphp

                        <div class="colores">
                            <p>Color:</p>
                            <span
                                class="color-circle color-btn"
                                data-color="{{ $producto->color }}"
                                style="background-color: {{ $colorCSS }};">
                            </span>

                        </div>

                        <div class="sizes">
                            <p>Talla:</p>
                            @foreach ($producto->tallas->where('cantidad', '>', 0) as $talla)
                            <button type="button" class="talla-btn" data-talla="{{ $talla->talla }}">
                                {{ $talla->talla }}
                            </button>
                            @endforeach
                        </div>

                        <br>
                        <a class="bottonspro" href="{{ route('inicio') }}"><button type="submit" class="productt">Agregar al carrito</button></a>
                        <a class="bottonspro" href="{{ route('inicio') }}"><button type="submit" class="productt">Seguir Mirando</button></a>
                    </form>


                </div>
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
        <script>
            // Validación al agregar al carrito
            function agregado(event) {
                event.preventDefault();

                const talla = document.getElementById('inputTalla').value;

                if (!talla) {
                    alert('⚠️ Por favor selecciona una talla antes de continuar.');
                    return;
                }

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


            // Cantidad
            function cambiarCantidad(valor) {
                const input = document.getElementById('cantidadInput');
                const visible = document.getElementById('cantidadVisible');
                let cantidad = parseInt(input.value) + valor;
                if (cantidad < 1) cantidad = 1;
                input.value = cantidad;
                visible.textContent = cantidad;
            }

            // Talla
            document.querySelectorAll('.talla-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.talla-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    document.getElementById('inputTalla').value = btn.dataset.talla;
                });
            });

            // Color
            document.querySelectorAll('.color-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    document.getElementById('inputColor').value = btn.dataset.color;
                });
            });

            // Talla
            document.querySelectorAll('.talla-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.talla-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    document.getElementById('inputTalla').value = btn.dataset.talla;
                });
            });
        </script>
        <script src="{{ asset('JS/script.js') }}"></script>
        <script src="{{ asset('JS/script2.js') }}"></script>
        <script src="{{ asset('JS/navbar.js') }}"></script>

        <script>
            function cambiarImagen(ruta) {
                document.getElementById('imagenGrande').src = ruta;
            }
        </script>
        <footer class="pie">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
            <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
            <a href="{{ route('redes') }}" class="abaj">Redes</a>
            <br><br>
            <p>&copy; 2024 - GUT KLEID.</p>
        </footer>
</body>

</html>