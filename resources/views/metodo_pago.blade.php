<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Método de Pago - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/ENVIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                            alt="Perfil"
                            class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}" class="filter-btn"><i class="bi bi-door-open"></i></a>
                    @else
                    <a href="{{ route('login') }}" class="inis">
                        <p class="filter-btn">INICIAR SESIÓN</p>
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
    </header>

    <!-- Main -->
    <main class="main">
        <div class="containercar">
            <h2 class="text-center">Método de Pago</h2>

            <form action="{{ route('metodo_pago.store') }}" method="POST" class="mt-4">
                @csrf

                <!-- Efectivo -->
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="radio" name="metodo_pago" id="efectivo" value="Efectivo" checked>
                    <label class="form-check-label" for="efectivo">
                        Efectivo
                    </label>
                </div>

                <!-- Transferencia -->
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="Transferencia">
                    <label class="form-check-label" for="transferencia">
                        Transferencia
                    </label>
                </div>

                <!-- Selección de banco (solo visible si elige transferencia) -->
                <div id="bancoCampo" class="mb-3" style="display: none;">
                    <label for="banco" class="form-label">Selecciona tu banco</label>
                    <select name="banco" id="banco" class="form-control">
                        <option value="">-- Selecciona una opción --</option>
                        <option value="Nequi">Nequi</option>
                        <option value="Daviplata">Daviplata</option>
                        <option value="Dale">Dale</option>
                        <option value="Nu">Nu</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="bottonfina">Confirmar Pago</button>
                    <a href="{{ route('carrito.index') }}" class="bottoncancela">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="pie">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        <a href="{{ route('reseñas') }}" class="abaj">Reseñas</a>
        <a href="{{ route('tiendas') }}" class="abaj">Tiendas</a>
        <a href="{{ route('redes') }}" class="abaj">Redes</a>
        <br><br>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>

    <!-- Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const efectivo = document.getElementById("efectivo");
            const transferencia = document.getElementById("transferencia");
            const bancoCampo = document.getElementById("bancoCampo");

            function toggleBanco() {
                bancoCampo.style.display = transferencia.checked ? "block" : "none";
            }

            // Inicializar
            toggleBanco();

            // Escuchar cambios
            efectivo.addEventListener("change", toggleBanco);
            transferencia.addEventListener("change", toggleBanco);
        });
    </script>
</body>
</html>
