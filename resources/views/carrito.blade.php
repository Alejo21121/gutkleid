<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/PAGINA PRINCIPAL.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>
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
                            <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil" class="perfil-icono">
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

<main class="main">
    <div class="containercar">
        <h2 class="text-center">Carrito de Compras</h2>

        @if(session('success'))
            <div class="alert alert-success text-center mt-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center mt-3">{{ session('error') }}</div>
        @endif

        @if(count($carrito) > 0)
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Precio U.</th>
                        <th>Subtotal</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
    @php $total = 0; @endphp
    @foreach($carrito as $id => $item)
        @php $total += $item['valor'] * $item['cantidad']; @endphp
        <tr>
            <td>
                <img src="{{ $item['imagen'] }}" alt="Imagen" width="70" height="70" style="object-fit: cover;">
            </td>
            <td>{{ $item['nombre'] }}</td> <!-- Solo nombre en descripción -->
            <td>
                <div class="cantidad-control">
    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" style="display: flex; align-items: center; gap: 5px;">
        @csrf
        <input type="hidden" name="tipo" value="restar">
        <button type="submit" class="bottoncantimen">-</button>
    </form>

    <span>{{ $item['cantidad'] }}</span>

    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" style="display: flex; align-items: center; gap: 5px;">
        @csrf
        <input type="hidden" name="tipo" value="sumar">
        <button type="submit" class="bottoncantimas">+</button>
    </form>
</div>
</td>

            <td>
    @if(!empty($item['talla']))
        {{ ucwords(strtolower($item['talla'])) }}
    @else
        <span class="text-muted">Sin talla</span>
    @endif
</td>

            <td>{{ $item['color'] }}</td> <!-- Color correcto -->
            <td>${{ number_format($item['valor'], 0, ',', '.') }}</td>
            <td>${{ number_format($item['valor'] * $item['cantidad'], 0, ',', '.') }}</td>
            <td>
                <form method="POST" action="{{ route('carrito.eliminar', $id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="bottonelim"><i class="bi bi-trash"></i></button>
                </form>
            </td>
        </tr>
    @endforeach
    <tr class="table-light">
        <td colspan="6" class="text-end"><strong>Total</strong></td>
        <td colspan="2"><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
    </tr>
</tbody>

                </table>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('carrito.vaciar') }}" class="bottonvaci">
                    <i class="bi bi-x-circle"></i> Vaciar carrito
                </a>

                @if(session('usuario'))
                    <form action="{{ route('carrito.finalizar') }}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" class="bottonfina">
                            <i class="bi bi-cash-coin"></i> Finalizar Compra
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bottonfina">
                        <i class="bi bi-cash-coin"></i> Inicia sesión para comprar
                    </a>
                @endif
            </div>
        @else
            <div class="text-center mt-4">
                <p>Tu carrito está vacío.</p>
                <a href="{{ route('inicio') }}" class="bottonvolve"><i class="bi bi-arrow-left"></i> Volver a comprar</a>
            </div>
        @endif
    </div>
</main>

<footer class="pie">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
</footer>

<script src="{{ asset('JS/script.js') }}"></script>
<script src="{{ asset('JS/script2.js') }}"></script>
<script src="{{ asset('JS/navbar.js') }}"></script>
</body>
</html>