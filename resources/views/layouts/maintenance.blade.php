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
    
    @include('partials/analyticstracking')

    <header class="header-site">
        <nav class="navbar navbar-toggleable-md navbar-inverse ">
            <div class="container">

                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="navbar__logo" src="{{ url('assets/img/logo_white.png') }}" alt="Logo Mycook">
                </a>

            </div>
        </nav>


    </header>

    @yield('content')

    <script type="text/javascript" src="{{mix("/assets/js/plugins-front.js")}}"></script>
    <script type="text/javascript" src="{{mix("/assets/js/front.js")}}"></script>
    @yield('script')

</body>
</html>