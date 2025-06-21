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
        <header class="cabeza">
            <nav class="barras">
                <div class="barra1">
                    <a href="{{ url()->previous() }}">
                        <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
                    </a>
                    <button class="filter-btn">Acerca de</button>
                </div>
                <div class="logo">
                <div class="iconos">
                    <a href="PAGINA PRINCIPAL.html">
                        <img src="IMG/LOGO3.PNG" alt="Logo">
                        </a>
                </div>
                <div class="barra2">
                <div class="usuario-info">
                    @if (session('usuario'))
                        <a href="{{ url('/logout') }}">
                            <button class="filter-btn">Cerrar sesión</button>
                        </a>
                    @else
                        <a href="{{ route('login') }}">
                            <button class="filter-btn">Inicia sesión</button>
                        </a>
                    @endif
                </div>
                <div class="iconos">
                    <a href="CARRITO DE COMPRAS.html"><button class="filter-btn"><i class="bi bi-cart3"></i></button></a>
                    @if (session('usuario'))
                        <a href="{{ route('cuenta') }}"><button class="filter-btn"><i class="bi bi-person-fill"></i> Mi cuenta </button></a>
                    @endif
                </div>
            </div>
            </nav>
        </header>
    </head>
<body>
    <main class="container">
        <h1>Términos y Condiciones</h1>
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
</body>
<footer class="pie">
    <div class="foot">
        <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
        <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
  </footer>
</html>