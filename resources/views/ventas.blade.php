<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/GESTION INVENTARIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>

<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ route('producto.index') }}"><button class="filter-bcc">Inventario</button></a>
                <a href="{{ route('analisis') }}"><button class="filter-bcc">Análisis</button></a>
                <a href="{{ route('usuarios.index') }}"><button class="filter-bcc">Usuarios</button></a>
                <a href="{{ route('compras.index') }}"><button class="filter-bcc">Compras</button></a>
                <a href="{{ route('ventas') }}"><button class="filter-bccselect">Ventas</button></a>

            </div>
            <div class="logo">
                <a href="/"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
            </div>
            <div class="barra2">
                <div class="usuario-info">
                    @if (session('usuario'))
                    <p class="user-name">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" alt="Perfil" class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}"><button class="filter-btn"><i class="bi bi-door-open"></i></button></a>
                    @else
                    <a href="{{ route('login') }}">
                        <p class="filter-btna">Inicia sesión</p>
                    </a>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="contenedor">
            <h2>
                <center>Ventas Registradas</center>
            </h2>
            <center>
                <form method="GET" action="{{ route('ventas') }}" class="d-flex mb-3 justify-content-center">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por ID" value="{{ request('buscar') }}">
                    <button type="submit" class="bottbusca"><i class="bi bi-search"></i></button>
                    <a href="" class="bottagrega"><i class="bi bi-plus-circle"></i></a>
                    <a href="" class="bottexc"><i class="bi bi-file-earmark-excel"></i></a>
                    <a href="" class="bottpdf"><i class="bi bi-file-pdf"></i></a>
                </form>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th># Factura</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Estado</th>
                            <th>Factura PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id_factura_venta }}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                            <td>{{ $venta->nombres }} - {{ $venta->documento }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                            <td>vendido</td>
                            <td>
                                @if($venta->factura_pdf)
                                <a href="{{ asset($venta->factura_pdf) }}" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf"></i> Ver
                                </a>
                                @else
                                <span class="text-muted">No generado</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-container">
                    {{ $ventas->links() }}
                </div>

                @if(request('buscar'))
                <div>
                    <a href="{{ route('ventas.index') }}" class="limpi"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
                @endif
            </center>
        </section>
    </main>

    <footer class="pie">
        <div class="foot">
            <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
            <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
        </div>
        <p>&copy; 2024 - GUT KLEID.</p>
    </footer>
</body>

</html>