@extends('layouts.default')
@section('content')

<section id="orders" class="addresses">
    <div class="container generic__wrapper">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fa fa-shopping" aria-hidden="true"></i> Meus Pedidos</h2>
                <h6>Acompanhe suas compras</h6>
            </div>
            <div>
                <a href="{{ url('lista-chefs') }}" class="btn btn-submit-orange mt-3 mb-3">
                    Nova Compra
                </a>    
            </div>
        </div>
        <hr>
        <!-- @include('flash::message') -->
        <list-orders></list-orders>

    </div>
</section>


@endsection

@section('script')
    <script>
        var orders = new Vue({
            el: '#orders',
            mounted() {
                console.log(Event)
            }
        });
    </script>
    
@endsection