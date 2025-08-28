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
                <!-- Menú Mujer -->
                <div class="categoria-menu" onmouseenter="mostrarMenu('mujer')" onmouseleave="ocultarMenu('mujer')">
                    <a class="filter-btn" href="{{ route('inicio', ['sexo' => 'Mujer']) }}">MUJER</a>
                    <div class="dropdown-menu-custom" id="menu-mujer">
                        <a class="dropdown-item-custom" href="{{ route('inicio', ['sexo' => 'Mujer']) }}">Todo</a>
                        @foreach($categoriasMujer as $categoria)
                        <div class="submenu">
                            <a class="dropdown-item-custom"
                                href="{{ route('inicio', ['sexo' => 'Mujer', 'categoria' => $categoria->id_categoria]) }}">
                                {{ $categoria->nombre }}
                            </a>
                            @if($categoria->subcategorias->count() > 0)
                            <div class="submenu-items">
                                @foreach($categoria->subcategorias as $sub)
                                <a class="dropdown-subitem-custom"
                                    href="{{ route('inicio', ['sexo' => 'Mujer', 'categoria' => $categoria->id_categoria, 'subcategoria' => $sub->id_subcategoria]) }}">
                                    {{ $sub->nombre }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Menú Hombre -->
                <div class="categoria-menu" onmouseenter="mostrarMenu('hombre')" onmouseleave="ocultarMenu('hombre')">
                    <a class="filter-btn" href="{{ route('inicio', ['sexo' => 'Hombre']) }}">HOMBRE</a>
                    <div class="dropdown-menu-custom" id="menu-hombre">
                        <a class="dropdown-item-custom" href="{{ route('inicio', ['sexo' => 'Hombre']) }}">Todo</a>
                        @foreach($categoriasHombre as $categoria)
                        <div class="submenu">
                            <a class="dropdown-item-custom" href="{{ route('inicio', ['sexo' => 'Hombre', 'categoria' => $categoria->id_categoria]) }}">
                                {{ $categoria->nombre }}
                            </a>
                            @if($categoria->subcategorias->count() > 0)
                            <div class="submenu-items">
                                @foreach($categoria->subcategorias as $sub)
                                <a class="dropdown-subitem-custom" href="{{ route('inicio', ['sexo' => 'Hombre', 'categoria' => $categoria->id_categoria, 'subcategoria' => $sub->id_subcategoria]) }}">
                                    {{ $sub->nombre }}
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- IZQUIERDA -->
                <div class="nav-left">
                    @if (session('usuario') && session('usuario')['id_rol'] == 1)
                    <a class="filter-btn" href="{{ route('producto.index') }}">PANEL</a>
                    @endif
                </div>
            </div> <!-- CENTRO -->
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

                    <!-- Buscador -->
                    <button id="toggleSearch" style="border:none; background:none; cursor:pointer;" class="busqueda">
                        <i class="bi bi-search" style="font-size:1.5rem;"></i>
                    </button>
                </div>
            </div>
        </nav>
        <!-- Panel de búsqueda -->
        <div id="search-panel" class="search-panel">
            <form method="GET" class="d-flex container" role="search">
                <input type="text" name="q" class="form-control me-2" placeholder="Buscar..." />
                <button type="submit" class="btn btn-dark">Buscar</button>
            </form>
        </div>
        <hr>

        <!-- Botón de filtro -->
        <button class="btn btn-dark" type="button" id="btnToggleSidebar">
            <i class="bi bi-funnel"></i> Filtrar
        </button>

        <!-- Sidebar de filtros -->
        <div id="sidebar" class="filter-sidebar">
            <form method="GET" action="{{ route('inicio') }}">
                <!-- Mantener categoría y sexo -->
                <input type="hidden" name="categoria" value="{{ $categoriaId ?? '' }}">
                <input type="hidden" name="sexo" value="{{ $sexo ?? '' }}">

                <!-- Filtro de Color -->
                <div class="mb-3">
                    <label>Color</label>
                    <select class="form-select" name="color">
                        <option value="">Todos</option>
                        @foreach($coloresDisponibles as $c)
                        <option value="{{ $c }}" {{ ($color ?? '') == $c ? 'selected' : '' }}>
                            {{ ucfirst($c) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro de Talla -->
                <div class="mb-3">
                    <label>Talla</label>
                    <select class="form-select" name="talla">
                        <option value="">Todas</option>
                        @foreach($tallasDisponibles as $t)
                        <option value="{{ $t }}" {{ ($talla ?? '') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>

                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-dark w-100">Aplicar filtros</button>
                <button type="button" id="btnCerrarSidebar" class="btn btn-secondary w-100 mt-2">Cerrar</button>
            </form>
        </div>

        <br><br>

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
                                @foreach ($producto->imagenes->take(2) as $imagen)
                                <img src="{{ asset($imagen->ruta) }}" class="mini-slide {{ $loop->first ? 'active' : '' }}">
                                @endforeach
                            </div>
                            <button type="button" class="prev" onclick="moverSlide(event, -1)">&#10094;</button>

                            <button type="button" class="next" onclick="moverSlide(event, 1)">&#10095;</button>
                        </div>
                    </a>
                    <h5>{{ $producto->nombre }}</h5>
                    <p><strong>${{ number_format($precioConIVA, 0, ',', '.') }} COP</strong></p>
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
        <script>
            const btn = document.getElementById('toggleSearch');
            const panel = document.getElementById('search-panel');
            let input = panel.querySelector('input[type="text"]');

            btn.addEventListener('click', () => {
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                    input.focus();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === "Escape") {
                    panel.style.display = "none";
                }
            });
        </script>

        <script src="{{ asset('JS/script.js') }}"></script>
        <script src="{{ asset('JS/script2.js') }}"></script>
        <script src="{{ asset('JS/navbar.js') }}"></script>

        <script>
            // Funciones para el menú hover
            function mostrarMenu(tipo) {
                const menu = document.getElementById(`menu-${tipo}`);
                menu.classList.add('show');
            }

            function ocultarMenu(tipo) {
                const menu = document.getElementById(`menu-${tipo}`);
                // Pequeño delay para permitir mover el mouse al menú
                setTimeout(() => {
                    if (!menu.matches(':hover')) {
                        menu.classList.remove('show');
                    }
                }, 100);
            }
            // Permitir que el menú permanezca abierto cuando el mouse está sobre él
            document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                menu.addEventListener('mouseenter', function() {
                    this.classList.add('show');
                });

                menu.addEventListener('mouseleave', function() {
                    this.classList.remove('show');
                });
            });

            // Cerrar menús al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.categoria-menu')) {
                    document.querySelectorAll('.dropdown-menu-custom').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        </script>

        <script>
            const sidebar = document.getElementById('sidebar');
            const btnOpen = document.getElementById('btnToggleSidebar');
            const btnClose = document.getElementById('btnCerrarSidebar');

            btnOpen.addEventListener('click', () => {
                sidebar.style.right = '0';
            });

            btnClose.addEventListener('click', () => {
                sidebar.style.right = '-300px';
            });
        </script>


        <footer class="pie">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
            <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
            <a href="{{ route('redes') }}" class="abaj">Redes</a>
            <br>
            <br>
            <p>&copy; 2024 - GUT KLEID.</p>
        </footer>

</body>

</html>