<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/CARRO.css') }}">
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

            <!-- Botón flotante de WhatsApp -->
            <a href="https://wa.me/573054212468"
                class="btn-whatsapp" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp">
            </a>

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
                </div>
            </div>
        </nav>
        <hr>

        <main class="main">
            <div class="containercar">
                <h2 class="text-center">Carrito de Compras</h2>

                {{-- MENSAJES DE ALERTA --}}
                @if(session('success'))
                <div class="alert alert-success text-center mt-3">
                    {{ session('success') }}
                    @if(session('factura_pdf'))
                    <br>
                    <a href="{{ session('factura_pdf') }}" class="btn btn-sm btn-primary mt-2" download>
                        <i class="bi bi-file-earmark-arrow-down"></i> Descargar Factura
                    </a>
                    @endif
                </div>
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
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Talla</th>
                                <th>Color</th>
                                <th>Precio U.</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0;
                            @endphp
                            @foreach($carrito as $id => $item)
                            @php
                            $valor = $item['valor'];
                            $iva = $valor * 0.19;
                            $valorConIva = round($valor + $iva, -3);
                            $subtotal = $valorConIva * $item['cantidad'];
                            $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <img src="{{ $item['imagen'] }}" alt="Imagen" width="70" height="70" style="object-fit: cover;">
                                </td>
                                <td>{{ $item['nombre'] }}</td>
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
                                <td>{{ $item['color'] ?? 'Sin color' }}</td>
                                <td>${{ number_format($valorConIva, 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('carrito.eliminar', $id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bottonelim"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @php $envio = $total >= 150000 ? 0 : 15000; @endphp

                            <tr class="table-light">
                                <td colspan="6" class="text-end"><strong>Subtotal</strong></td>
                                <td><strong>${{ number_format($total, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-end"><strong>Gastos de envío</strong></td>
                                <td><strong>${{ number_format($envio, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="6" class="text-end">
                                    <strong>Total</strong><br>
                                </td>
                                <td><strong>${{ number_format($total + $envio, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('carrito.vaciar') }}" class="bottonvaci">
                        Vaciar carrito
                    </a>

                    @if(session('usuario'))
                    <a href="{{ route('envio.index') }}" class="bottonfina">Siguiente</a>
                    <i class="bi bi-cash-coin"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="bottonfina">
                        <i class="bi bi-cash-coin"></i> Inicia sesión para comprar
                    </a>
                    @endif

                </div>
                @else
                <div class="text-center mt-4">
                    <p>Tu carrito está vacío.</p>
                    <a href="{{ route('inicio') }}" class="bottonvolve"> Volver a comprar</a>
                </div>
                @endif
            </div>
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