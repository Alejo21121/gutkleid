<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/INFORMACIONCUENTA.css') }}">
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
            <div class="content-wrapper col-12">
                <section id="main">
                    <header class="page-header">
                        <h1 class="max-subpages-heading text-center">Mi Cuenta</h1>
                    </header>
                    <br>
                    <section id="content" class="page-content">
                        <ul class="my-account-links row">
                            <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
                                <a id="identity-link" href="{{ route('cuenta_cli') }}">
                                    <i class="bi bi-person-circle"></i>
                                    INFORMACION
                                </a>
                            </li>

                            <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
                                <a id="address-link" href="{{ route('perfil.editar') }}">
                                    <i class="bi bi-card-checklist"></i>
                                    Actualizar información
                                </a>
                            </li>

                            <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
                                <a id="history-link" href="{{ route('direccion') }}">
                                    <i class="bi bi-geo-alt"></i>
                                    Mi Dirección
                                </a>
                            </li>

                            <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
                                <a id="order-slips-link" href="{{ route('historial') }}">
                                    <i class="bi bi-receipt-cutoff"></i>
                                    Historial de pedidos
                                </a>
                            </li>
                        </ul>
                    </section>
                </section>
            </div>
        </main>
        </center>
    </header>

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
