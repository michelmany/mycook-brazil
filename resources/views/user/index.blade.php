@extends('layouts.default')
@section('title', 'Entre ou Cadastre-se')
@section('content')
    <section class="hero-pages"
        style="background-image: url('/assets/img/hero-01.jpg')">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <div class="cadastro wrapper">

        <div class="container">

            <div class="row justify-content-md-center">
                <div class="col-md-6 col-lg-5 px-0 pb-3">
                    <div class="cadastro__headline text-center">
                        Quero me cadastrar
                    </div>
                    <div id="cadastro-form" class="cadastro__form-content">

                    <a href="{{ route('facebookAuth', 'facebook') }}" class="btn btn-facebook cadastro__button">
                        <i class="fa fa-facebook"></i> Cadastrar com facebook</a>
                    <button class="btn btn-email cadastro__button" v-on:click="show = !show">
                        <i class="fa fa-envelope-o"></i>Cadastrar com Email</button>

                        @if (count($errors) > 0)
                            <div class="text-danger">
                                Validação falhou...
                            </div>
                        @endif

                        <transition name="slide-fade">
                            <div class="cadastrar__form-email mt-2 mb-3" @if (count($errors) === 0) v-if="show" @endif>
                                <form action="{{ route('registerPost', compact('intended')) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg input__entrar"
                                            name="name" required placeholder="Digite seu nome" value="{{old('name')}}">
                                        @include('components.error', ['field'=>'name'])
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg input__entrar"
                                            name="email" required placeholder="Digite seu email" value="{{old('email')}}">
                                        @include('components.error', ['field'=>'email'])
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg input__entrar"
                                            name="password" required placeholder="Digite sua senha mycook" value="{{old('password')}}">
                                        @include('components.error', ['field'=>'password'])
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg input__entrar"
                                            name="confirm_password" required placeholder="Confirme sua senha" value="">
                                        @include('components.error', ['field'=>'password'])
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg input__entrar"
                                            name="phone" required placeholder="Digite seu telefone" value="{{old('phone')}}">
                                        @include('components.error', ['field'=>'phone'])
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="true" name="aceito-termos" checked>
                                            @include('components.error', ['field'=>'aceito-termos'])
                                        </label>
                                        <span data-toggle="modal" data-target="#modalTermos" style="cursor: pointer">Li e aceito os termos de uso e as políticas de privacidade.</span>
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-submit-green btn-lg" type="submit">Cadastrar</button>
                                    </div>
                                </form>
                            </div><!-- /cadastrar com email -->
                        </transition>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>

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

                <div class="col-md-6 col-lg-5 px-0 pt-3 pt-md-0 pt-sm-3">

                    <div class="cadastro__headline text-center">Já sou cadastrado</div>

                    <div class="cadastro__form-content">
                        <a href="{{ route('facebookAuth', 'facebook') }}" class="btn btn-facebook cadastro__button"><i class="fa fa-facebook"></i> Acessar com facebook</a>

                        @if (session('validation-error'))
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> {{ session('validation-error') }}
                            </div>
                        @endif

                        <form action="{{ route('login', compact('intended')) }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg input__entrar" name="email" value="{{ old('email') }}" required placeholder="Digite seu email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg input__entrar" name="password" required placeholder="Digite sua senha">
                            </div>
                            <div class="">
                                <button class="btn btn-submit-green btn-lg" type="submit">Entrar</button>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label cadastro__check-label">
                                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar de mim
                                </label>
                            </div>

                        </form>
                    </div>
                    <!-- /form-content -->
                    
                     <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="cadastro__link ">Recuperar senha?</a>
                    </div>
                    
                </div>
            </div>

            <div class="line-vertical hidden-sm-down"></div>

        </div><!-- /container -->


    </div>
        


@endsection

@section('script')
    <script>
    const cadastroForm = new Vue({
        el: '#cadastro-form',
        data: {
            show:  false
        }
    });
    </script>
@endsection