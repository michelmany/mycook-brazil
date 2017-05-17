<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{mix("/assets/css/style.css")}}" rel="stylesheet" type="text/css">
    <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
    </script>
    <title>@yield('title') - MyCook</title>
</head>
<body>
    <header class="header-site">
        <nav class="navbar navbar-toggleable-md navbar-inverse ">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ route('sobre') }}">
                    <img class="navbar__logo" src="{{ url('assets/img/logo_white.png') }}" alt="Logo Mycook">
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li {{ (Request::is('/') ? 'class=active' : '') }}>
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li {{ (Request::is('sobre') ? 'class=active' : '') }}>
                            <a class="nav-link" href="{{ route('sobre') }}">Sobre mycook</a>
                        </li>
                        <li {{ (Request::is('quero-vender') ? 'class=active' : '') }}>
                            <a class="nav-link" href="{{ route('queroVender') }}">Quero vender no mycook</a>
                        </li>
                        <li {{ (Request::is('como-funciona') ? 'class=active' : '') }}>
                            <a class="nav-link" href="{{ route('comoFunciona') }}">Como funciona</a>
                        </li>
                        <li {{ (Request::is('contato') ? 'class=active' : '') }}>
                            <a class="nav-link" href="{{ route('contato') }}">Contato</a>
                        </li>
                    </ul>

                    <a href="{{ route('authHome') }}" class="btn btn-outline-white my-2 my-lg-0 ml-lg-3">Entrar ou Cadastrar</a>

                </div>
            </div>
        </nav>


    </header>

    @yield('content')

    <script type="text/javascript" src="{{mix("/assets/js/plugins-front.js")}}"></script>
    <script type="text/javascript" src="{{mix("/assets/js/front.js")}}"></script>
</body>
</html>