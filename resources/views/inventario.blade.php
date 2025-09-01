    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="{{ asset('CSS/GESTION INVENTARIO.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
    </head>

    <body>
        <header class="cabeza">
            <nav class="barras">
                <div class="barra1">
                    <a href="{{ route('producto.index') }}"><button class="filter-bccselect">Inventario</button></a>
                    <a href="{{ route('analisis') }}"><button class="filter-bcc">Análisis</button></a>
                    <a href="{{ route('usuarios.index') }}"><button class="filter-bcc">Usuarios</button></a>
                    <a href="{{ route('compras.index') }}"><button class="filter-bcc">Compras</button></a>
                </div>
                <div class="logo">
                    <a href="/"><img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo"></a>
                </div>
                <div class="barra2">
                    <div class="usuario-info">
                        @if (session('usuario'))
                        <p class="user-name">Hola {{ session('usuario')['nombres'] }}</p>
                        <a href="{{ route('cuenta') }}">
                            <img src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                                alt="Perfil"
                                class="perfil-icono">
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
                    <center>Inventario</center>
                </h2>
                <center>
                    <form method="GET" action="{{ route('producto.index') }}" class="d-flex mb-3 justify-content-center">
                        <input type="text" name="buscar" class="form-control" placeholder="Buscar por ID" value="{{ request('buscar') }}">
                        <button type="submit" class="bottbusca"><i class="bi bi-search"></i></button>
                        <a href="{{ route('producto.create') }}" class="bottagrega"><i class="bi bi-plus-circle"></i></a>
                        <a href="{{ route('producto.exportarExcel') }}" class="bottexc"><i class="bi bi-file-earmark-excel"></i></a>
                        <a href="{{ route('producto.exportarPDF') }}" class="bottpdf"><i class="bi bi-file-pdf"></i></a>
                    </form>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Nombre</th>
                                <th>Valor U</th>
                                <th>IVA(19%)</th>
                                <th>Marca</th>
                                <th>Sexo</th>
                                <th>Talla</th>
                                <th>Color</th>
                                <th>Categoría</th>
                                <th>Cantidad</th>
                                <th>Imagen</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            @php
                            $iva = $producto->valor * $producto->iva; // ya está la tasa guardada
                            @endphp
                            <tr>
                                <td>{{ $producto->id_producto }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>${{ number_format($producto->valor, 0, ',', '.') }}</td>

                                <td>${{ number_format($iva, 0, ',', '.') }}</td>
                                <td>{{ $producto->marca }}</td>
                                <td>{{ $producto->sexo }}</td>
                                <td>
                                    @foreach ($producto->tallas as $t)
                                    <span>{{ $t->talla }} ({{ $t->cantidad }})<br></span>
                                    @endforeach
                                </td>
                                <td>{{ $producto->color }}</td>
                                <td>
                                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                    @if($producto->subcategoria)
                                    <br><small style="color: #6c757d;">→ {{ $producto->subcategoria->nombre }}</small>
                                    @endif
                                </td>

                                <td>
                                    {{ $producto->tallas->sum('cantidad') }}
                                </td>
                                <td>
                                    @if ($producto->imagenes->isNotEmpty())
                                    <a href="{{ route('producto.imagenes', $producto->id_producto) }}">
                                        <img src="{{ asset($producto->imagenes->first()->ruta) }}" alt="Imagen del producto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    </a>
                                    @else
                                    <a href="{{ route('producto.imagenes', $producto->id_producto) }}" class="bottimg">
                                        <i class="bi bi-images"></i>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('producto.edit', $producto->id_producto) }}" class="bottedit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('producto.destroy', $producto->id_producto) }}?page={{ request('page') }}&buscar={{ request('buscar') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bottbor"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <div class="pagination-container">
                        @if ($productos->onFirstPage())
                        <span class="botsig disabled" style="pointer-events: none; opacity: 0.5;">Anterior</span>
                        @else
                        <a href="{{ $productos->previousPageUrl() }}&buscar={{ request('buscar') }}" class="botsig">Anterior</a>
                        @endif

                        <span class="pagina-info">Página {{ $paginaActual }} de {{ $totalPaginas }}</span>

                        @if ($productos->hasMorePages())
                        <a href="{{ $productos->nextPageUrl() }}&buscar={{ request('buscar') }}" class="botsig">Siguiente</a>
                        @else
                        <span class="botsig disabled" style="pointer-events: none; opacity: 0.5;">Siguiente</span>
                        @endif
                    </div>

                    <br>
                    @if(request('buscar'))
                    <div>
                        <a href="{{ route('producto.index') }}" class="limpi"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                    @endif
                </center>
            </section>
        </main>
        @if(count($advertencias) > 0)
        <div class="alert alert-warning mt-4" style="width: 80%; margin: 0 auto;">
            <h5><i class="bi bi-exclamation-triangle-fill"></i> Advertencias de Stock Bajo</h5>
            <ul>
                @foreach($advertencias as $a)
                <li>
                    Producto <strong>#{{ $a['id'] }} - {{ $a['nombre'] }}</strong> tiene <strong>{{ $a['cantidad'] }}</strong> unidades en talla <strong>{{ $a['talla'] }}</strong>
                </li>
                @endforeach
            </ul>
        </div>
        @endif


        <footer class="pie">
            <div class="foot">
                <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
                <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
            </div>
            <p>&copy; 2024 - GUT KLEID.</p>
        </footer>
    </body>

    </html>