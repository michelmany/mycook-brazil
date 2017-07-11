@extends('layouts.default')
@section('content')

<section id="list-chefs-page" class="list-chefs">

{{--     <div class="search-chef">
        <div class="container">
            <form class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  <input type="search" class="form-control form-control-lg input__entrar" id="search-chef" placeholder="Buscar Chef">
              </div>
          </form>
      </div>
  </div> --}}

  <section class="chef-header" style="background-color: white;">
    <div class="container generic__wrapper">
        <div class="row">
        <div class="col-md-2">
                <div class="chef-item__photo mr-3">
                    {{-- <img src="https://graph.facebook.com/10154279898587202/picture?type=large" class="rounded-circle" width="150" height="150"> --}}
                    <img class="rounded-circle" src="/assets/img/not-found-avatar.png" width="150" height="150" style="background-color: #E9EBEE;">
                </div>
            </div>

            <div class="col-md-6">
                <h3>{{ $seller->name }}</h3>
                <div class="chef-item__distance"><small class="text-uppercase">A 1.3 Km de distância</small></div>
                <p>A casa aposta no conceito de gastrobar, ou seja, oferece uma boa gastronomia com toda a descontração de um bar. No cardápio assinado pelo chef Waldomiro Santos, que tem passagem pelo Bar des Arts e O Leopolldo, pratos com toque autoral como a picanha grelhada ao molho à base de creme de leite e shoyu com shiitake laminado, guarnecido de risoto do próprio molho.</p>
            </div>
            <div class="col-md-4">
                Rate
            </div>
        </div>
    </div>
</section>

<div class="chefs-list">
    <div class="container generic__wrapper">
        <div class="header mb-3">
        </div>


        <div class="row">

            {{-- {{ dd($seller) }} --}}

            <div class="col-md-8 col-lg-8">

                <div class="chef-item__box">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="chef-item__photo mr-3">
                            <img src="https://graph.facebook.com/10154279898587202/picture?type=large" width="120" height="120">
                        </div>
                        <div class="chef-item__text ">
                            <h5 class=""><strong>Salada Prosciuto</strong></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
                        </div>
                        <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                    </div>
                </div>

                <div class="chef-item__box">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="chef-item__photo mr-3">
                            <img src="https://graph.facebook.com/10154279898587202/picture?type=large" width="120" height="120">
                        </div>
                        <div class="chef-item__text ">
                            <h5 class=""><strong>Salada Prosciuto</strong></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
                        </div>
                        <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                    </div>
                </div>

                <div class="chef-item__box">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="chef-item__photo mr-3">
                            <img src="https://graph.facebook.com/10154279898587202/picture?type=large" width="120" height="120">
                        </div>
                        <div class="chef-item__text ">
                            <h5 class=""><strong>Salada Prosciuto</strong></h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
                        </div>
                        <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-lg-4">

                <div class="card text-center">
                    <div class="card-header">
                        <h5>Seu carrinho</h5>
                        <div><strong>{{ $seller->name }}</strong></div>
                    </div>
                    <div class="card-block">
                    <h4 class="card-title">Carrinho vazio</h4>
                        <p class="card-text">Tá esperando o que?</p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Código do cupom">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Go!</button>
                            </span>
                        </div>
                       <a href="#" class="btn btn-primary btn-block">Finalizar compra</a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


</section>


@endsection