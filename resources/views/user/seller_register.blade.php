@extends('layouts.default')
@section('title', 'Quero vender no mycook')
@section('content')

<section class="hero-pages" 
    style="background-image: url('/assets/img/hero-05.jpg')"">
    <div class="hero-pages__mask"></div>
    <div class="container">
        <div class="hero-pages__headline ml-auto">@yield('title')</div>
    </div>
</section>

<section class="quero-vender generic__wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="generic__headline">Alguns dos benefícios em fazer parte do mycook.</div>
                <ul class="generic__list">
                    <li>Faça a sua agenda com os dias e horários que deseja vender os seus produtos no mycook, de acordo com a sua disponibilidade.</li>
                    <li>Você decide a quantidade de produtos que deseja vender por dia.</li>
                    <li>Você só paga para a mycook, se o seu produto for vendido.</li>
                    <li>Ser o seu próprio chefe e trabalhar por conta própria, com o mycook é possível!</li>
                    <li>Queremos aumentar a visibilidade do seu negocio, através de investimentos de marketing, promoção e publicidade.</li>
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
            <div class="form-chef__headline">Seja muito bem-vindo ao mycook!</div> 
            <div class="form-chef__copy">
                <p>Será um prazer enorme ter você em nossa plataforma.
                Para vender no mycook, preencha o formulário abaixo e aguarde nosso contato.</p>
                <p>Se tudo estiver ok com o seu cadastro, você receberá um e-mail informando que o seu cadastro foi disponibilizado.</p>
                <p>Pronto! Você já poderá começar a vender os seus produtos no mycook.</p>
            </div>
        </div>
    </div>



    <div class="form-chef__form">
        <div id="ContainerFormVendedor" class="container">
{{--             <form id="formCadastroVendedor" @submit.prevent="validateBeforeSubmit" action="{{ route('queroVenderPost') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
            </form> --}}


            <front-cadastro-vendedor></front-cadastro-vendedor>


        </div>

    </div>

</section>

@endsection

@section('script')
    <script type="text/javascript" src="{{mix("/assets/js/vendedor.js")}}"></script>
@endsection