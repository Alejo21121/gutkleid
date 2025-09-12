<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/ENVIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>

<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="nav-left">
                @if (session('usuario') && session('usuario')['id_rol'] == 1)
                <a class="filter-btn" href="{{ route('producto.index') }}">Panel</a>
                @endif
            </div>

            <div class="nav-center">
                <a href="/">
                    <div class="logo">
                        <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                    </div>
                </a>
            </div>

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
    </header>
    <main class="main">
        <div class="containercar">
            <h2 class="text-center">Confirmación de Entrega</h2>
            <form id="envio-form" action="{{ route('carrito.finalizar') }}" method="POST">
                @csrf
                
                @php
                    $direccionFormulario = data_get($envio ?? [], 'direccion') ?? '';
                    $infoAdicionalFormulario = data_get($envio ?? [], 'info_adicional') ?? '';
                    $tipoEntregaFormulario = data_get($envio ?? [], 'tipo_entrega') ?? 'domicilio';
                @endphp
            
                <input type="hidden" name="tipo_entrega" value="{{ $tipoEntregaFormulario }}">
                <input type="hidden" name="direccion" value="{{ $direccionFormulario }}">
                <input type="hidden" name="info_adicional" value="{{ $infoAdicionalFormulario }}">

                <table class="table table-bordered mt-4">
                    <tr>
                        <th>Documento</th>
                        <td>{{ optional($persona)->documento ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de nacimiento</th>
                        <td>{{ optional($persona)->fecha_nacimiento ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Nombres</th>
                        <td>{{ optional($persona)->nombres ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Apellidos</th>
                        <td>{{ optional($persona)->apellidos ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Correo</th>
                        <td>{{ optional($persona)->correo ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ optional($persona)->telefono ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $direccionMostrada }}</td>
                    </tr>
                    <tr>
                        <th>Información adicional</th>
                        <td>
                            <textarea name="info_adicional" class="form-control" rows="3"
                                placeholder="Agrega información adicional para la entrega...">{{ $infoAdicional }}</textarea>
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Talla</th>
                            <th>Color</th>
                            <th>Cantidad</th>
                            <th>Total (con IVA)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detallesCarrito as $item)
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>{{ $item['talla'] }}</td>
                            <td>{{ $item['color'] }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>$ {{ number_format(round($item['total'] * 1.19), 0, ",", ".") }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" class="text-end">Subtotal</th>
                            <td>$ {{ number_format(round($subtotal + $ivaTotal, -3), 0, ",", ".") }}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Gastos de envío</th>
                            <td>$ {{ number_format(round($costoEnvio, -3), 0, ",", ".") }}</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Valor a pagar</th>
                            <td><strong>$ {{ number_format(round($totalFinal, -3), 0, ",", ".") }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('carrito.index') }}" class="bottonvolver">
                        Volver al carrito
                    </a>
                    <button type="submit" class="bottonpaga">
                        Pagar
                    </button>
                </div>
            </form>
        </div>
    </main>
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