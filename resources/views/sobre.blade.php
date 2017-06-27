@extends('layouts.default')
@section('title', 'Sobre')
@section('content')

<!-- facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=342396965800879";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- /facebook -->


    <section class="hero-pages" 
        style="background-image: url('/assets/img/hero-02.jpg')"">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <section class="sobre">
        <div class="container">
            <div class="row">
                <div class="col-lg-7  generic__wrapper">
                    <div class="sobre__copy text-justify">
                        <p>A paixão pela comida, a falta de opções de delivery para comida caseira e o cheiro delicioso dos pratos cozinhados pela minha vizinha, fez surgir o mycook.</p>
                        <p>O mycook é a plataforma que tem como objetivo unir cozinheiros e chefs com talento na cozinha com quem quer comer uma comida caseira, beber uma cerveja artesanal, comer uma sobremesa dos deuses ou até mesmo tomar aquele suco natural, pagando um preço justo e tudo com a comodidade e facilidade de um delivery.</p>
                         <p>Queremos dar visibilidade e criar oportunidade para o pequeno empreendedor e estimular o comercio local, facilitando a vida de quem quer empreender mas, nao dispõe de grandes quantias para investir.</p>
                        {{-- <p>Atualmente, atendemos somente a Região Metropolitana do Rio de Janeiro.</p> --}}
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-center bg-color-gray hidden-sm-down">
                    <div class="sobre__right-col mx-auto">
                        <div class="sobre__curta">
                            Curta o <span>MyCook</span> no facebook!
                        </div>
                        <div class="facebook_like-box">
                            <div class="fb-page" data-href="https://www.facebook.com/mycook.br" data-width="402" data-height="215" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/mycook.br" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/mycook.br">MyCook Brasil</a></blockquote></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection