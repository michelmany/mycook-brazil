@extends('layouts.default')
@section('title', 'Registro')
@section('content')

    <h1>Registro index</h1>

    <ul>
        <li><a href="/auth/social/redirect/facebook">Cadastrar com Facebook</a></li>
        <li><a href="/auth/register">Cadastar com email</a></li>
        <li><a href="/auth/social/redirect/facebook">Acessar com Facebook</a></li>
    </ul>

@endsection