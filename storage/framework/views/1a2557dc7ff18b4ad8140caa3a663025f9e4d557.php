<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="<?php echo e(mix("/assets/css/style.css")); ?>" rel="stylesheet" type="text/css">
    <script>
      window.Laravel = <?php echo json_encode([
          'csrfToken' => csrf_token(),
      ]); ?>
    </script>
    <title>MyCook | Delivery de comida caseira online | <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Polyfill for the v-tooltip etc -->
    <script src="https://ft-polyfill-service.herokuapp.com/v2/polyfill.js?features=es6"></script>

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
    
    <?php echo $__env->make('partials/analyticstracking', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <header class="header-site">
        <nav class="navbar navbar-toggleable-md navbar-inverse ">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php if(Auth::check()): ?>

                    <a class="navbar-brand" href="<?php echo e(route('lista-chefs-page')); ?>">
                        <img class="navbar__logo" src="<?php echo e(url('assets/img/logo_white.png')); ?>" alt="Logo Mycook">
                    </a>

                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="ml-auto hidden-md-down">
                            <?php $firstName = explode(' ', trim(Auth::user()->name)); ?> 
                            <div class="text-white">Olá <strong><?php echo e($firstName[0]); ?></strong>, bem-vindo(a)!
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split text-white" 
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php if(Auth::user()->social): ?>
                                            <img src="https://graph.facebook.com/<?php echo e(Auth::user()->social->provider_user_id); ?>/picture?type=large" 
                                                 class="rounded-circle ml-2" width="50" height="50">
                                        <?php else: ?> 
                                            <img src="<?php echo e(url('assets/img/not-found-avatar_small.png')); ?>" 
                                                 class=" avatar-dropdown rounded-circle ml-2" width="40" height="40">
                                        <?php endif; ?>    
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="<?php echo e(route('profile')); ?>">Perfil</a>
                                        <a class="dropdown-item" href="<?php echo e(route('profile.adresses')); ?>">Meus Endereços</a>
                                        <a class="dropdown-item disabled" href="">Avaliações</a>
                                        <a class="dropdown-item" href="<?php echo e(route('orders.list')); ?>">Acompanhar pedidos</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Sair</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav ml-auto hidden-lg-up">
                            <li <?php echo e((Request::is('/') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('home')); ?>">Perfil</a>
                            </li>
                            <li <?php echo e((Request::is('sobre') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('profile.adresses')); ?>">Meus endereços</a>
                            </li>
                            <li <?php echo e((Request::is('quero-vender') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('queroVender')); ?>">Avaliações</a>
                            </li>
                            <li <?php echo e((Request::is('como-funciona') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('comoFunciona')); ?>">Acompanhar pedidos</a>
                            </li>
                            <li>
                                <a class="nav-link" href="<?php echo e(route('logout')); ?>">Sair</a>
                            </li>
                        </ul>

                    </div>

                <?php else: ?> 

                    <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                        <img class="navbar__logo" src="<?php echo e(url('assets/img/logo_white.png')); ?>" alt="Logo Mycook">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav ml-auto">
                            <li <?php echo e((Request::is('/') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                            </li>
                            <li <?php echo e((Request::is('sobre') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('sobre')); ?>">Sobre MyCook</a>
                            </li>
                            <li <?php echo e((Request::is('quero-vender') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('queroVender')); ?>">Quero vender no MyCook</a>
                            </li>
                            <li <?php echo e((Request::is('como-funciona') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('comoFunciona')); ?>">Como funciona</a>
                            </li>
                            <li <?php echo e((Request::is('contato') ? 'class=active' : '')); ?>>
                                <a class="nav-link" href="<?php echo e(route('contato')); ?>">Contato</a>
                            </li>
                        </ul>

                        <a href="<?php echo e(route('authHome')); ?>" class="btn btn-outline-white my-2 my-lg-0 ml-lg-3">Entrar ou Cadastrar</a>
                    </div>

                <?php endif; ?>

            </div>
        </nav>


    </header>

    <?php echo $__env->yieldContent('content'); ?>

    <footer class="footer-site">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="footer__widget-01">
                        <div class="footer__headline">Institucional</div>
                        <ul class="footer__items">
                            <li><a href="<?php echo e(route('sobre')); ?>">Sobre MyCook</a></li>
                            <li><a href="<?php echo e(route('termos')); ?>">Termos e condições de uso</a></li>
                            <li><a href="<?php echo e(route('privacidade')); ?>">Privacidade</a></li>
                            <li><a href="<?php echo e(route('authHome')); ?>">Cadastre-se</a></li>
                            <li><a href="<?php echo e(route('contato')); ?>">Contato</a></li>
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

    <script type="text/javascript" src="<?php echo e(mix("/assets/js/plugins-front.js")); ?>"></script>
    <script type="text/javascript" src="<?php echo e(mix("/assets/js/front.js")); ?>"></script>
    <?php echo $__env->yieldContent('script'); ?>

</body>
</html>