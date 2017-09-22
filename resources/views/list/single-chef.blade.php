@extends('layouts.default')
@section('content')

<section id="single-chef-page" class="list-chefs">

    <section class="chef-header" style="background-color: white;">
        <div class="container generic__wrapper">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    <div class="chef-item__photo mr-3">
                        {{-- <img src="https://graph.facebook.com/10154279898587202/picture?type=large" class="rounded-circle" width="150" height="150"> --}}
                        <img class="rounded-circle" src="{{ $seller->avatar_full_url }}" width="150" height="150" style="background-color: #E9EBEE;">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <h3>{{ $seller->name }}</h3>
                    
                    @if ($seller->distance)
                        <div class="chef-item__distance"><small class="text-uppercase">A {{$seller->distance}} Km de distância</small></div>
                    @endif

                    <p>A casa aposta no conceito de gastrobar, ou seja, oferece uma boa gastronomia com toda a descontração de um bar. No cardápio assinado pelo chef Waldomiro Santos, que tem passagem pelo Bar des Arts e O Leopolldo, pratos com toque autoral como a picanha grelhada ao molho à base de creme de leite e shoyu com shiitake laminado, guarnecido de risoto do próprio molho.</p>
                </div>
                <div class="col-md-3 col-lg-4">
                    {{-- Avaliação --}}
                </div>
            </div>
        </div>

    </section>

    <div class="chefs-list">
        <div class="container generic__wrapper">
            <div class="header mb-3">
                <h2>Cardápio</h2>
            </div><br>

            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <cardapio :chef-id="{{ $seller->seller->id }}" :chef="{{ $seller }}" :chef-moip-id="{{ $moipseller }}"></cardapio>
                </div>
                <div class="col-md-12 col-lg-4 hidden-md-down">
                    <cart chef-name="{{ $seller->name }}" chef-moip-id="{{ $moipseller->moipId }}"></cart>
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
        data: {}
    });
</script>
@endsection