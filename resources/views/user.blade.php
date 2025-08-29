<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">

  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Mi Cuenta - Gut Kleid</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('CSS/USER.CSS') }}">
  <link rel="stylesheet" href="https://ld-prestashop.template-help.com/prestashop_15325_demo1/themes/_libraries/font-awesome/css/font-awesome.min.css" type="text/css" media="all">
  <link rel="stylesheet" href="https://ld-prestashop.template-help.com/prestashop_15325_demo1/themes/theme1511/assets/css/theme.css" type="text/css" media="all">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <header class="cabeza">
    <nav class="barras">
      <div class="barra1">
        <a href="{{ url()->previous() }}">
          <button class="filter-btn"><i class="bi bi-arrow-left"></i> Volver</button>
        </a>
        <a href="{{ url('/reseñas') }}">
          <button class="filter-btn">Acerca de</button>
        </a>
      </div>

      <div class="logo">
        <a href="{{ route('inicio') }}">
          <img src="{{ asset('IMG/LOGO3.PNG') }}" alt="Logo">
        </a>
      </div>

      <div class="barra2">
        <p class="sesionn">Hola {{ session('usuario')['nombres'] }}</p>
        <a href="{{ url('/logout') }}"> </a>
        <a href="{{ route('carrito.index') }}">
          <button class="filter-btn"><i class="bi bi-cart3"></i></button>
        </a>
      </div>
    </nav>
  </header>

<body id="my-account" class=" page-my-account ">

  <div class="content-wrapper  col-12">
    <section id="main">

      <header class="page-header">
        <h1 class="max-subpages-heading text-center">Mi Cuenta</h1>
      </header>

      <section id="content" class="page-content">

        <ul class="my-account-links row">


          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a id="identity-link" href="{{ route('cuenta_cli') }}">
              <img
                src="{{ asset(session('usuario')['imagen'] ?? 'IMG/default.jpeg') }}"
                alt="Perfil"
                class="img-perfil-usuario">
              INFORMATION
            </a>
          </li>

          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a id="address-link" href="{{ route('perfil.editar') }}">
              <i class="bi bi-card-checklist" aria-hidden="true"></i>
              Actualizar informacion
            </a>
          </li>

          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a id="history-link" href="{{ route('direccion') }}">
              <i class="bi bi-geo-alt" aria-hidden="true"></i>
              MI Direccion
            </a>
          </li>

          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a id="order-slips-link" href="{{ route('historial') }}">
              <i class="bi bi-receipt-cutoff" aria-hidden="true"></i>
              Historial de pedidos
            </a>
          </li>

          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a href="https://ld-prestashop.template-help.com/prestashop_15325_demo1/index.php?fc=module&amp;module=jxheaderaccount&amp;controller=facebooklink&amp;id_lang=1" title="Facebook Login Manager">
              <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
              Devoluciones </a>
          </li>
          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a href="https://ld-prestashop.template-help.com/prestashop_15325_demo1/index.php?fc=module&amp;module=jxheaderaccount&amp;controller=googlelogin&amp;id_lang=1" title="Google Login Manager">
              <i class="fa fa-google-plus" aria-hidden="true"></i>
              Connect With Google </a>
          </li>
          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a href="https://ld-prestashop.template-help.com/prestashop_15325_demo1/index.php?fc=module&amp;module=jxheaderaccount&amp;controller=vklogin&amp;id_lang=1" title="VK Login Manager">
              <i class="bi bi-heart" aria-hidden="true"></i>
              Favoritos </a>
          </li>

          <li class="ma-link-item col-lg-2 col-md-3 col-sm-4 col-6">
            <a href="{{ url('/logout') }}">
              <i class="bi bi-door-open" aria-hidden="true"></i>
              <span>CERRAR SESIÓN</span>
            </a>
          </li>


        </ul>

  </div>


  <footer class="pie">
    <div class="foot">
      <a href="{{ route('terminos') }}" class="abaj">Términos y Condiciones</a>
      <a href="{{ route('preguntas') }}" class="abaj">Preguntas Frecuentes</a>
    </div>
    <p>&copy; 2024 - GUT KLEID.</p>
  </footer>

</html>