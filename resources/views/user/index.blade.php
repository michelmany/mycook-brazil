@extends('layouts.default')
@section('title', 'Entre ou Cadastre-se')
@section('content')

    <section class="hero-pages" 
        style="background-image: url('/assets/img/placeholder-hero-image.jpg')"">
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

                            <transition name="slide-fade">
                                <div class="cadastrar__form-email mt-2 mb-3" v-if="show">
                                    <form action="{{ route('registerPost') }}" method="post">
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
                                                name="password" required placeholder="Confirme sua senha" value="">
                                            @include('components.error', ['field'=>'password'])
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg input__entrar" 
                                                name="phone" required placeholder="Digite seu telefone" value="{{old('phone')}}">
                                            @include('components.error', ['field'=>'phone'])
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="aceito-termos"> Li e aceito os termos de uso e as políticas de privacidade.
                                            </label>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-submit-green btn-lg" type="submit">Cadastrar</button>
                                        </div>
                                    </form>
                                </div><!-- /cadastrar com email -->
                            </transition>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 px-0 pt-3 pt-md-0 pt-sm-3">

                    <div class="cadastro__headline text-center">Já sou cadastrado</div>

                    <div class="cadastro__form-content">
                        <a href="{{ route('facebookAuth', 'facebook') }}" class="btn btn-facebook cadastro__button"><i class="fa fa-facebook"></i> Acessar com facebook</a>

                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg input__entrar" name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu email">
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
                    </div><!-- /form-content -->

                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="cadastro__link ">Recuperar senha?</a>
                    </div>

                </div>
            </div>

            <div class="line-vertical hidden-sm-down"></div>

        </div><!-- /container -->


    </div>
        


@endsection