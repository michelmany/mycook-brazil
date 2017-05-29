@extends('layouts.default')
@section('title', 'Como funciona')
@section('content')

    <section class="hero-pages" 
        style="background-image: url('/assets/img/hero-03.jpg')"">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <section class="como-funciona">
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                <div class="col-md-6">
                    <div class="como-funciona__image-container d-flex">
                        <img src="/assets/img/como-funciona@2x.png" 
                            class="como-funciona__image img-fluid align-self-center ml-md-auto">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="como-funciona__content">
                        <div class="generic__headline">Veja como é fácil fazer seu pedido no mycook.</div>
                        <ul class="generic__list">
                            <li>Pesquise pelo(s) produto(s) desejado(s)</li>
                            <li>Faça seu pedido pelo nosso site</li>
                            <li>O chef produzirá o seu produto.</li>
                            <li>Um entregador levará o seu pedido.</li>
                            <li>Comida Caseira entregue em sua casa</li>
                        </ul>
                        <a href="{{ route('authHome') }}" class="btn btn-outline-primary feature__read-more generic__button--black-outline">Entrar ou Cadastrar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection