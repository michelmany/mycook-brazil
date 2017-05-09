<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{mix("/assets/css/style.css")}}" rel="stylesheet" type="text/css">
    <title>@yield('title') - MyCook</title>
</head>
<body>
    <header class="header-site">
        <nav class="navbar navbar-toggleable-md navbar-inverse">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img class="navbar__logo" src="{{ url('assets/img/logo_white.png') }}" alt="">
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sobre mycook</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Quero vender no mycook</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Como funciona</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contato</a>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-outline-white my-2 my-sm-0 ml-sm-3">Entrar ou Cadastrar</a>

                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <!--<script type="text/javascript" src="{{mix("/assets/js/app.js")}}"></script>-->
</body>
</html>