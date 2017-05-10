@extends('layouts.default')
@section('title', 'Registro')
@section('content')

    <h1>Registro index</h1>

    <ul>
        <li><a href="{{ route('facebookAuth', 'facebook') }}">Cadastrar com Facebook</a></li>
        <li><a href="{{ route('register') }}">Cadastar com email</a></li>
        <li><a href="{{ route('facebookAuth', 'facebook') }}">Acessar com Facebook</a></li>
    </ul>

    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}

        <div>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
        </div>
        <div>
            <input type="password" name="password" required placeholder="Senha">
        </div>
        <div>
            <input type="checkbox" title="Lembrar de mim" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar de mim
        </div>

        <input type="submit" value="Acessar">
        <a  href="{{ route('password.request') }}">Recuperar senha?</a>
    </form>

@endsection