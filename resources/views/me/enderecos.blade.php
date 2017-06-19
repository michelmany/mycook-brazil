@extends('layouts.default')
@section('content')


    <section class="addresses">
        <div class="container generic__wrapper">
            <div class="header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2><i class="fa fa-map-marker" aria-hidden="true"></i> Meus Endereços</h2>
                    <h6>Selecione o endereço de entrega</h6>
                </div>
                <div>
                    <button class="btn btn-submit-orange mt-3 mb-3">Adicionar Endereço</button>    
                </div>
            </div>
            <hr>
            <div class="address__item d-flex justify-content-between align-items-center">
                <div>
                    <div class="address__title">Casa</div>
                    <div class="address__address">R JEQUIE , 71 - Barcelona BARCELONA - SERRA</div>
                </div>
                <div class="ml-auto address__close-icon">
                    <a href=""><i class="fa fa-times" aria-hidden="true"></i></i></a>
                </div>
            </div>

            <div class="address__item d-flex justify-content-between align-items-center">
                <div>
                    <div class="address__title">Casa</div>
                    <div class="address__address">R JEQUIE , 71 - Barcelona BARCELONA - SERRA</div>
                </div>
                <div class="ml-auto address__close-icon">
                    <a href=""><i class="fa fa-times" aria-hidden="true"></i></i></a>
                </div>
            </div>
        </div>
    </section>


@endsection