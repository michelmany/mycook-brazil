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
    <title>MyCook | Delivery de comida caseira online | @yield('title')</title>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '816561605162281'); // Insert your pixel ID here.
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=816561605162281&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

</head>
<body>
    
    @include('partials/analyticstracking')

    <header class="header-site">
        <nav class="navbar navbar-toggleable-md navbar-inverse ">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                @if (Auth::check())

                    <a class="navbar-brand" href="{{ route('listaChefs') }}">
                        <img class="navbar__logo" src="{{ url('assets/img/logo_white.png') }}" alt="Logo Mycook">
                    </a>

                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="ml-auto hidden-md-down">
                            <?php $firstName = explode(' ', trim(Auth::user()->name)); ?> {{-- To get the First name only --}}
                            <div class="text-white">Olá <strong>{{  $firstName[0] }}</strong>, bem-vindo(a)!
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split text-white" 
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if (Auth::user()->social)
                                            <img src="https://graph.facebook.com/{{ Auth::user()->social->provider_user_id }}/picture?type=large" 
                                                 class="rounded-circle ml-2" width="50" height="50">
                                        @else 
                                            <img src="{{ url('assets/img/not-found-avatar_small.png') }}" 
                                                 class=" avatar-dropdown rounded-circle ml-2" width="40" height="40">
                                        @endif    
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('profile') }}">Perfil</a>
                                        <a class="dropdown-item" href="{{ route('profile.adresses') }}">Meus Endereços</a>
                                        <a class="dropdown-item disabled" href="{{-- {{ route('profile.score') }} --}}">Avaliações</a>
                                        <a class="dropdown-item disabled" href="{{-- {{ route('profile.adresses') }} --}}">Acompanhar pedidos</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav ml-auto hidden-lg-up">
                            <li {{ (Request::is('/') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('home') }}">Perfil</a>
                            </li>
                            <li {{ (Request::is('sobre') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('profile.adresses') }}">Meus endereços</a>
                            </li>
                            <li {{ (Request::is('quero-vender') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('queroVender') }}">Avaliações</a>
                            </li>
                            <li {{ (Request::is('como-funciona') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('comoFunciona') }}">Acompanhar pedidos</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('logout') }}">Sair</a>
                            </li>
                        </ul>

                    </div>

                @else 

                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img class="navbar__logo" src="{{ url('assets/img/logo_white.png') }}" alt="Logo Mycook">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav ml-auto">
                            <li {{ (Request::is('/') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li {{ (Request::is('sobre') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('sobre') }}">Sobre MyCook</a>
                            </li>
                            <li {{ (Request::is('quero-vender') ? 'class=active' : '') }}>
                                <a class="nav-link" href="{{ route('queroVender') }}">Quero vender no MyCook</a>
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

                @endif

            </div>
        </nav>


    </header>

    @yield('content')

    <footer class="footer-site">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="footer__widget-01">
                        <div class="footer__headline">Institucional</div>
                        <ul class="footer__items">
                            <li><a href="{{ route('sobre') }}">Sobre MyCook</a></li>
                            <li><a href="{{ route('termos') }}">Termos e condições de uso</a></li>
                            <li><a href="{{ route('privacidade') }}">Privacidade</a></li>
                            <li><a href="{{ route('authHome') }}">Cadastre-se</a></li>
                            <li><a href="{{ route('contato') }}">Contato</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="footer__widget-02 text-lg-right mt-3 mt-md-0">
                        <div class="social-icons">
                            <ul>
                                <a href="https://www.facebook.com/mycook.br" target="_blank">
                                    <li class="social-icon social-icon__facebook"><i class="fa fa-facebook"></i></li></a>
                                <a href="https://www.instagram.com/mycook.br" target="_blank">
                                    <li class="social-icon social-icon__instagram"><i class="fa fa-instagram"></i></li></a>
                            </ul>
                        </div>
                        <div class="footer__credits">
                            MyCook © Copyright 2017 - Todos os direitos reservados<br>
                            Desenvolvido pela <a href="https://www.nitdesign.com.br" target="_blank" style="color:#fff">NITDESIGN</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <script type="text/javascript" src="{{mix("/assets/js/plugins-front.js")}}"></script>
    <script type="text/javascript" src="{{mix("/assets/js/front.js")}}"></script>
    @yield('script')

</body>
</html>