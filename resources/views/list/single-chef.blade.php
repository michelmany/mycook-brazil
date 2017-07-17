@extends('layouts.default')
@section('content')

<section id="single-chef-page" class="list-chefs">

    <section class="chef-header" style="background-color: white;">
        <div class="container generic__wrapper">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    <div class="chef-item__photo mr-3">
                        {{-- <img src="https://graph.facebook.com/10154279898587202/picture?type=large" class="rounded-circle" width="150" height="150"> --}}
                        <img class="rounded-circle" src="{{ $seller->avatar_full_url}}" width="150" height="150" style="background-color: #E9EBEE;">
                    </div>
                </div>

                {{-- {{ dd($seller )}} --}}

                <div class="col-md-6 col-lg-6">
                    <h3>{{ $seller->name }}</h3>
                    
                    <div class="chef-item__distance"><small class="text-uppercase">A {{$seller->distance}} Km de distância</small></div>
                    <p>A casa aposta no conceito de gastrobar, ou seja, oferece uma boa gastronomia com toda a descontração de um bar. No cardápio assinado pelo chef Waldomiro Santos, que tem passagem pelo Bar des Arts e O Leopolldo, pratos com toque autoral como a picanha grelhada ao molho à base de creme de leite e shoyu com shiitake laminado, guarnecido de risoto do próprio molho.</p>
                </div>
                <div class="col-md-3 col-lg-4">
                    Avaliação
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

                <div class="col-md-12 col-lg-8">
                    <cardapio></cardapio>
                </div>

                <div class="col-md-12 col-lg-4 hidden-md-down">

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
                                    <button class="btn btn-secondary" type="button">Aplicar</button>
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

@section('script')
<script>
    var SingleChefsPage = new Vue({
        el: '#single-chef-page',
        data: {
            oi: "oii"
        }
    });
</script>
@endsection