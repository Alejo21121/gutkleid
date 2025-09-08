<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gut Kleid - Usuarios</title>
    <link rel="stylesheet" href="{{ asset('CSS/GESTION INVENTARIO.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('IMG/icono2.ico') }}" type="image/x-icon">
</head>
<body>
    <header class="cabeza">
        <nav class="barras">
            <div class="barra1">
                <a href="{{ route('producto.index') }}" class="inis"><button type="button" class="botonmenu">Inventario</button></a>
                <a href="{{ route('analisis') }}" class="inis"><button type="button" class="botonmenu">Análisis</button></a>
                <a href="{{ route('usuarios.index') }}" class="inis"><button type="button" class="botonmenu">Usuarios</button></a>
                <a href="{{ route('compras.index') }}" class="inis"><button type="button" class="botonmenu">Compras</button></a>
                <a href="{{ route('ventas') }}" class="inis"><button type="button" class="botonmenu">Ventas</button></a>
            </div>
            <div class="logo">
                <a href="{{ route('inicio') }}">
                    <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
                </a>
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
                        <a href="{{ route('logout') }}" class="inis"><button class="botonmenu"><i class="bi bi-door-open"></i></button></a>
                    @else
                        <a href="{{ route('login') }}"><p class="filter-btna">Inicia sesión</p></a>
                    @endif
                </div>
            </div>
        </nav>
        <hr>
    <main class="main">
        <div class="container-login">
            <h2><center>Gestión de Usuarios</center></h2>
            <center>
                <form action="{{ route('usuarios.index') }}" method="GET" class="d-flex mb-3 justify-content-center">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por ID" value="{{ request('buscar') }}">
                    <button type="submit" class="bottbusca"><i class="bi bi-search"></i></button>
                    <a href="{{ route('usuarios.create') }}" class="bottagrega"><i class="bi bi-plus-circle"></i></a>
                    <a href="{{ route('usuarios.exportarExcel') }}" class="bottexc"><i class="bi bi-file-earmark-excel"></i></a>
                    <a href="{{ route('usuarios.exportarPDF') }}" class="bottpdf"><i class="bi bi-file-pdf"></i></a>
                </form>

                <div class="tabla-scroll">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>ID Persona</th>
                                <th>Documento</th>
                                <th>Tipo Doc</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->id_persona }}</td>
                                    <td>{{ $usuario->documento }}</td>
                                    <td>{{ $usuario->tipoDocumento->nombre ?? 'Sin tipo' }}</td>
                                    <td>{{ $usuario->nombres }}</td>
                                    <td>{{ $usuario->apellidos }}</td>
                                    <td>{{ $usuario->telefono }}</td>
                                    <td>{{ $usuario->correo }}</td>
                                    <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                                    <td>
                                        <a href="{{ route('usuarios.edit', $usuario->id_persona) }}"><button class="bottedit"><i class="bi bi-pencil"></i></button></a>
                                        <form action="{{ route('usuarios.destroy', $usuario->id_persona) }}?page={{ request('page') }}&buscar={{ request('buscar') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bottbor"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br>
                <div class="pagination-container">
                    @if ($usuarios->onFirstPage())
                        <span class="bottpagi disabled" style="pointer-events: none; opacity: 0.5;">Anterior</span>
                    @else
                        <a href="{{ $usuarios->previousPageUrl() }}&buscar={{ request('buscar') }}" class="bottpagi">Anterior</a>
                    @endif

                    <span class="pagina-info">Página {{ $paginaActual }} de {{ $totalPaginas }}</span>

                    @if ($usuarios->hasMorePages())
                        <a href="{{ $usuarios->nextPageUrl() }}&buscar={{ request('buscar') }}" class="bottpagi">Siguiente</a>
                    @else
                        <span class="bottpagi disabled" style="pointer-events: none; opacity: 0.5;">Siguiente</span>
                    @endif
                </div>

                <br>
                @if(request('buscar'))
                    <div>
                        <a href="{{ route('usuarios.index') }}" class="limpi"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                @endif
            </center>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
