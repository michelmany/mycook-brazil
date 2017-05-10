@extends('layouts.default')
@section('title', 'Registro')
@section('content')

    <h1>Registro</h1>

    <form action="{{ route('registerPost') }}" method="post">
        {{ csrf_field() }}
        <div>
            <input type="text" name="name" placeholder="Seu nome..." value="{{old('name')}}">
            @include('components.error', ['field'=>'name'])
        </div>
        <div>
            <input type="text" name="cpf" placeholder="Seu CPF..." value="{{old('cpf')}}">
            @include('components.error', ['field'=>'cpf'])
        </div>
        <div>
            <input type="email" name="email" placeholder="Seu email..." value="{{old('email')}}">
            @include('components.error', ['field'=>'email'])
        </div>
        <div>
            <input type="password" name="password" placeholder="Sua senha..." value="{{old('password')}}">
            @include('components.error', ['field'=>'password'])
        </div>
        <div>
            <input type="text" name="phone" placeholder="Seu telefone" value="{{old('phone')}}">
            @include('components.error', ['field'=>'phone'])
        </div>
        <div>
            <input type="date" name="birth" placeholder="Data de aniversário" value="{{old('birth')}}">
            @include('components.error', ['field'=>'birth'])
        </div>
        <input type="submit" value="Salvar">
    </form>
    <p><a href="{{ route('authHome') }}">Voltar</a></p>

@endsection