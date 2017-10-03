@extends('layouts.default')
@section('title', 'Registrar')
@section('content')

    <section class="hero-pages" 

        style="background-image: url('/assets/img/hero-01.jpg')"">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <div class="cadastro wrapper">

        <div class="container">
            <div class="mx-auto" style="width: 285px;">
                <form action="{{ route('registerPost') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg input__entrar" 
                            name="name" placeholder="Seu nome..." value="{{old('name')}}">
                        @include('components.error', ['field'=>'name'])
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg input__entrar" 
                            name="cpf" placeholder="Seu CPF..." value="{{old('cpf')}}">
                        @include('components.error', ['field'=>'cpf'])
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-lg input__entrar" 
                            name="email" placeholder="Seu email..." value="{{old('email')}}">
                        @include('components.error', ['field'=>'email'])
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg input__entrar" 
                            name="password" placeholder="Sua senha..." value="{{old('password')}}">
                        @include('components.error', ['field'=>'password'])
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg input__entrar" 
                            name="phone" placeholder="Seu telefone" value="{{old('phone')}}">
                        @include('components.error', ['field'=>'phone'])
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control form-control-lg input__entrar"
                            name="birth" placeholder="Data de aniversário" value="{{old('birth')}}">
                        @include('components.error', ['field'=>'birth'])
                    </div>
                    <div class="">
                        <button class="btn btn-submit-green btn-lg" type="submit">Cadastrar</button>
                    </div>
                </form>
            </div><!-- /container -->

    </div>
    </div>

@endsection