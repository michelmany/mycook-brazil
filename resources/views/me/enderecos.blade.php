@extends('layouts.default')
@section('content')


    <section id="addresses" class="addresses">
        <div class="container generic__wrapper">
            <div class="header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2><i class="fa fa-map-marker" aria-hidden="true"></i> Meus Endereços</h2>
                    <h6>Selecione o endereço de entrega</h6>
                </div>
                <div>
                    <button class="btn btn-submit-orange mt-3 mb-3" @click="showBuscaCep = true">Adicionar Endereço</button>
                </div>
            </div>
            <hr>

            @include('flash::message')

            <transition name="fade">
                <new-address v-if="showBuscaCep"></new-address>
            </transition>

            <address-items></address-items>

        </div>
    </section>


@endsection

@section('script')
    <script>
        var addresses = new Vue({
            el: '#addresses',
            data: {
                showBuscaCep: false
            },
            mounted() {
                $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

                Event.$on('added', (res) => {
                    this.showBuscaCep = false;
                });
            }
        });
    </script>
    <style>
        .fade-enter-active,
        .fade-leave-active {
          transition: opacity .5s
        }
        .fade-enter,
        .fade-leave-to {
          opacity: 0
        }
    </style>
@endsection
