<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gut Kleid</title>
        <link rel="stylesheet" href="CSS/CARRITO DE COMPRAS.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
        <link rel="icon" href="IMG/icono2.ico" class="imagenl" type="image/x-icon" >
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
            </div></a>
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
    <!-- Caja de login -->
    <div class="container-login">
        <h2>Términos y Condiciones</h2>
        <br>
        <p>
            Bienvenido a nuestra tienda en línea de ropa. Al utilizar nuestro sitio web, aceptas cumplir con los siguientes términos y condiciones:
        </p>
        <ul>
            <li>Los productos están sujetos a disponibilidad en inventario.</li>
            <li>Los precios pueden cambiar sin previo aviso.</li>
            <li>No se permite el uso de este sitio web para actividades fraudulentas.</li>
            <li>El cliente es responsable de proporcionar datos de envío precisos.</li>
            <li>Para devoluciones o cambios, consulta nuestra política de reembolso.</li>
        </ul>
        <p>Si tienes alguna pregunta, contáctenos a través de nuestro correo: contacto@tienda.com</p>
    </main>
    </main>
</body>
<script>
const btn   = document.getElementById('toggleSearch');
const panel = document.getElementById('search-panel');
let input   = panel.querySelector('input[type="text"]');

btn.addEventListener('click', () => {
    if(panel.style.display === "block"){
        panel.style.display = "none";
    } else {
        panel.style.display = "block";
        input.focus();
    }
});

document.addEventListener('keydown', (e)=>{
    if(e.key === "Escape"){
        panel.style.display = "none";
    }
});
</script>
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