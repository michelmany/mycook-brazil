@extends('layouts.default')
@section('title', 'Registro')
@section('content')

    <h1>Registro de Chef</h1>

    <form action="{{ route('queroVenderPost') }}" method="post">
        {{ csrf_field() }}
        <div>
            <input type="text" name="user[name]" placeholder="Nome completo" value="{{old('name')}}">
            @include('components.error', ['field'=>'name'])
        </div>

        <div>
            <input type="text" name="user[cpf]" placeholder="CPF" value="{{old('cpf')}}">
            @include('components.error', ['field'=>'cpf'])
        </div>

        <div>
            <input type="number" name="address[cep]" placeholder="CEP" value="{{old('cep')}}">
            @include('components.error', ['field'=>'cep'])
        </div>

        <div>
            <input type="text" name="address[address]" placeholder="Endereço completo" value="{{old('address')}}">
            @include('components.error', ['field'=>'address'])
        </div>

        <div>
            <input type="text" name="address[number]" placeholder="Número" value="{{old('number')}}">
            @include('components.error', ['field'=>'number'])
        </div>

        <div>
            <input type="text" name="address[complement]" placeholder="Complemento" value="{{old('complement')}}">
            @include('components.error', ['field'=>'complement'])
        </div>

        <div>
            <input type="text" name="address[neighborhood]" placeholder="Bairro" value="{{old('neighborhood')}}">
            @include('components.error', ['field'=>'neighborhood'])
        </div>

        <div>
            <input type="text" name="address[city]" placeholder="Município" value="{{old('city')}}">
            @include('components.error', ['field'=>'city'])
        </div>

        <div>
            <input type="text" name="address[state]" placeholder="UF" value="{{old('state')}}">
            @include('components.error', ['field'=>'state'])
        </div>

        <div>
            <input type="email" name="user[email]" placeholder="Email" value="{{old('email')}}">
            @include('components.error', ['field'=>'email'])
        </div>

        <div>
            <input type="text" name="buyer[phone]" placeholder="Telefone" value="{{old('phone')}}">
            @include('components.error', ['field'=>'phone'])
        </div>

        <div>
            <input type="text" name="buyer[formacao]" placeholder="Sua Formação" value="{{old('formacao')}}">
            @include('components.error', ['field'=>'formacao'])
        </div>

        <div>
            <input type="text" name="buyer[facebook]" placeholder="Facebook" value="{{old('facebook')}}">
            @include('components.error', ['field'=>'facebook'])
        </div>

        <div>
            <input type="text" name="buyer[instagram]" placeholder="Intagram" value="{{old('instagram')}}">
            @include('components.error', ['field'=>'instagram'])
        </div>

        <!--<div>
            <input type="text" name="name" placeholder="Quais pratos deseja vender no mycook?" value="{{old('name')}}">
            @include('components.error', ['field'=>'name'])
        </div>

        <div>
            <input type="text" name="name" placeholder="Você cozinha?" value="{{old('name')}}">
            @include('components.error', ['field'=>'name'])
        </div>-->

        <input type="submit" value="Cadastrar">
    </form>

@endsection