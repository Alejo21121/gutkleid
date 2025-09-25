<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/ENVIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
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
                </div>
            </div>
        </nav>
        <hr>
        <!-- Header -->
        <main class="main">
            <main class="containercar">
                <div class="container-confirmacion text-center">
                    <i class="bi bi-check-circle-fill icon-success mb-3"></i>
                    <h2 class="mb-3">¡Gracias por tu compra!</h2>
                    <p class="lead">Tu pedido ha sido procesado exitosamente. Recibirás un correo electrónico con la
                        confirmación y los detalles de tu compra.</p>
                    <p><strong>Número de Factura:</strong> #{{ $factura->id_factura_venta }}</p>

                    <hr class="my-4">

                    <h4>Resumen de la compra</h4>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Talla</th>
                                        <th>Color</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalProductos = 0;
                                    @endphp
                                    @foreach ($factura->detalles as $detalle)
                                    @php
                                    $valorUnitario = $detalle->producto->valor;
                                    $ivaUnit = $valorUnitario * 0.19;
                                    $valorUnitConIva = round($valorUnitario + $ivaUnit, -3); // redondeo al múltiplo de 1000
                                    $totalLinea = $valorUnitConIva * $detalle->cantidad;
                                    $totalProductos += $totalLinea;
                                    @endphp
                                    <tr>
                                        <td>{{ $detalle->producto->nombre }}</td>
                                        <td>{{ $detalle->talla->talla }}</td>
                                        <td>{{ $detalle->color ?? 'N/A' }}</td>
                                        <td>{{ $detalle->cantidad }}</td>
                                        <td>$ {{ number_format($totalLinea, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @php
                                    // Envío gratis si total productos >= 150.000
                                    $gastosEnvio = $totalProductos >= 150000 ? 0 : $factura->envio;
                                    $totalPagar = $totalProductos + $gastosEnvio;
                                    @endphp

                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Gastos de envío:</strong></td>
                                        <td>
                                            $ {{ number_format($gastosEnvio, 0, ',', '.') }}
                                            @if ($gastosEnvio == 0)
                                            <span style="color: green; font-weight:bold;">🎉 Envío Gratis</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total a Pagar:</strong></td>
                                        <td><strong>$ {{ number_format($totalPagar, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('inicio') }}" class="bottonpaga">Volver al inicio</a>
                    </div>
                </div>
            </main>
        </main>
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