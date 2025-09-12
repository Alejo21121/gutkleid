<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación - Gut Kleid</title>
    <link rel="stylesheet" href="{{ asset('CSS/CONFIRMACION.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
    <script src="https://checkout.bold.co/library/boldPaymentButton.js"></script>
</head>

<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="nav-left">
                @if(session('usuario') && session('usuario')['id_rol']==1)
                <a class="filter-btn" href="{{ route('producto.index') }}">Panel</a>
                @endif
            </div>
            <div class="nav-center">
                <a href="/">
                    <div class="logo"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></div>
                </a>
            </div>
            <div class="nav-right">
                <div class="usuario-info">
                    @if(session('usuario'))
                    <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
                    <a href="{{ route('cuenta') }}">
                        <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}" class="perfil-icono">
                    </a>
                    <a href="{{ route('logout') }}" class="filter-btn"><i class="bi bi-door-open"></i></a>
                    @else
                    <a href="{{ route('login') }}" class="inis">
                        <p class="filter-btn">INICIAR SESION</p>
                    </a>
                    @endif
                    <a href="{{ route('carrito.index') }}" class="fontcarr"><i class="bi bi-cart3"></i></a>
                </div>
            </div>
        </nav>
        <hr>
    </header>

    <main class="main">
        <div class="containercar">
            <h2 class="text-center">Confirmación de Entrega</h2>
            @php
            $direccionMostrada = data_get($envio, 'direccion') ?? optional($persona)->direccion ?? 'Sin dirección';
            $infoAdicional = old('info_adicional', data_get($envio, 'info_adicional') ?? optional($persona)->info_adicional ?? '');
            @endphp
            <form id="envio-form" action="{{ route('envio.guardar') }}" method="POST">
                @csrf
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
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detallesCarrito as $item)
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>{{ $item['talla'] }}</td>
                            <td>{{ $item['color'] }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>$ {{ number_format(round($item['total'], -3), 0, ",", ".") }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="4">Valor a pagar</th>
                            <td><strong>$ {{ number_format(round($totalFinal, -3), 0, ",", ".") }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('carrito.index') }}" class="bottonvolve">
                        <i class="bi bi-arrow-left-circle"></i> Volver al carrito
                    </a>
                    <button type="button" id="btn-bold-checkout" class="btn btn-primary">
                        Pagar con Bold
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutButton = document.getElementById('btn-bold-checkout');

            checkoutButton.addEventListener('click', function() {
                // Se inyectan los valores de PHP en variables de JavaScript
                const orderId = @json($orderId);
                const amount = @json(intval($totalFinal * 100));
                const integritySignature = @json($integritySignature);
                const publicKey = @json($publicKey); // AÑADE ESTA LÍNEA

                // Verifica si las variables son nulas antes de continuar
                if (!orderId || !integritySignature || !publicKey) {
                    console.error("Error: Faltan credenciales de Bold.");
                    alert("No se pudo iniciar el pago. Intenta de nuevo.");
                    return;
                }

                const boldCheckout = new BoldCheckout({
                    orderId: orderId,
                    amount: amount,
                    currency: 'COP',
                    auth: {
                        apiKey: publicKey, // CAMBIA ESTO a la nueva variable
                        token: integritySignature
                    },
                    description: 'Compra en Gut Kleid',
                    redirectionUrl: @json(route('compra.confirmacion'))
                });

                boldCheckout.open();
            });
        });
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