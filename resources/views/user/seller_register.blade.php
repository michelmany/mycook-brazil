@extends('layouts.default')
@section('title', 'Quero vender no MyCook')
@section('content')

<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>

<section class="hero-pages" 
    style="background-image: url('/assets/img/hero-05.jpg')">
    <div class="hero-pages__mask"></div>
    <div class="container">
        <div class="hero-pages__headline ml-auto">@yield('title')</div>
    </div>
</section>

<section class="quero-vender generic__wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="generic__headline">Alguns dos benefícios em fazer parte do MyCook.</div>
                <ul class="generic__list">
                    <li>Seja visto e faça parte do maior shopping center gastronômico de comida caseira do Brasil.</li>
                    <li>Você mesmo monta os dias e horários que deseja comercializar os seus produtos de acordo com a sua disponibilidade. </li>
                    <li>Com o MyCook, voce poderá conciliar o seu trabalho habitual, proporcionando assim, uma renda extra no final do mês.</li>
                    <li>Você decide quantas refeições ou produtos deseja vender por dia.</li>
                    <li>Você só paga para o MyCook, se o seu produto for vendido.</li>
                    <li>Com o MyCook, você só precisa se preocupar em fazer o produto incrível para encantar e conquistar o seu cliente, pronto. Deixe o resto conosco.</li>
                    <li>Nossa equipe trabalhará para impulsionar as suas vendas.</li>
                    <li>Qualquer pessoa com talento na cozinha, poderá se candidatar gratuitamente para vender os seus produtos no MyCook.</li>
                </ul>
                <a href="#form-chef" class="btn btn-outline-primary feature__read-more generic__button--black-outline">Cadastrar agora</a>
            </div>
            <div class="offset-md-1 col-md-5 d-flex align-items-center">
                <div class="quero-vender__image-container d-flex">
                    <img src="/assets/img/sobre-01.jpg" 
                        class="quero-vender__image img-fluid align-self-center">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="form-chef" class="form-chef generic__wrapper">
    <div class="form-chef__head text-center">
        <div class="container">
            <div class="form-chef__headline">Seja muito bem-vindo ao MyCook!</div> 
            <div class="form-chef__copy">
                <p>Será um prazer enorme ter você em nossa plataforma.
                Para vender no MyCook, preencha o formulário abaixo e aguarde nosso contato.</p>
                <p>Se tudo estiver ok com o seu cadastro, você receberá um e-mail informando que o seu cadastro foi disponibilizado.</p>
                <p>Pronto! Você já poderá começar a vender os seus produtos no MyCook.</p>
            </div>
        </div>
    </div>

    <div class="form-chef__form">
        <div id="ContainerFormVendedor" class="container">

            <front-cadastro-vendedor></front-cadastro-vendedor>

            <!-- Modal Termos -->
            <div class="modal fade" id="modalTermos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#F95700">
                            <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">TERMOS E CONDIÇÕES DE USO MYCOOK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('./partials/termos')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /modal -->

        </div>
    </div>

</section>

@endsection

@section('script')
    <script>
        const formChef = new Vue({
            el: '#ContainerFormVendedor'
        });
    </script>
@endsection