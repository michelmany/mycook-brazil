@extends('layouts.default')
@section('title', 'Home')
@section('content')


    <section class="hero-image"
    style="background-image: url('/assets/img/hero-image-01.jpg')">
        <div class="hero-image__mask"></div>

        <div class="hero-image__content">
            <div class="hero-image__headline">Delivery de comida caseira online</div>
            <div class="hero-image__subline">Comida caseira de verdade da cozinha do chef para sua mesa</div>
            
            <div class="hero-image__search">
                <form action="/list" class="form-inline d-flex justify-content-center" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="q" class="form-control mb-2 mr-sm-2 mb-sm-0 search__input" placeholder="Digite seu CEP:">
                    <button class="btn search__button" type="submit">Buscar</button>
                </form>
                <p class="search__text mt-3">Não sabe o CEP? <br class="hidden-sm-up"><strong>Clique aqui</strong> e digite seu endereço.</p>
            </div> 

        </div>
 
    </section>

    <section class="feature">
    <div class="container">
        <div class="row">
                <div class="col-md-6">
                    <img class="feature__image mb-3 mb-lg-0" src="/assets/img/family-eating.jpg">
                </div>
                <div class="col-md-6">
                    <div class="feature__headline mb-3">Delivery com os <strong>melhores chefs</strong> ao alcance de suas mãos.</div>
                    <div class="feature__subline mb-3">É rápido e fácil!</div>
                    <div class="feature__copy mb-3">
                        Mycook é a plataforma ideal para pedir aquela comida caseira pagando menos, de uma forma rápida e fácil.
                        Quem não gosta de uma comida caseira bem feita? 
                        Para todos os momentos e ocasiões, peça pelo mycook!
                    </div>
                    <a href="{{ route('comoFunciona') }}" class="btn btn-outline-primary feature__read-more">Saiba mais</a>
                </div>
          </div>
        </div>
    </section>

    <section class="soon">
        <div class="container">
            <img class="soon__image" src="/assets/img/em-breve.png">
        </div>
    </section>

@endsection