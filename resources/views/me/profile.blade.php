@extends('layouts.default')
@section('title', 'Registrar')
@section('content')

<div>
    <h1>Meu perfil</h1>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<div id="cadastro-form">
    <avatar photo-url="{{ $user->avatar_full_url }}"></avatar>
</div>

<div>
    <h3>Informações pessoais</h3>
    <form method="post" action="{{ route('profile.post') }}">

        {!! csrf_field() !!}

        <label for="formNome">Nome</label>
        <input type="text" name="user[name]" id="formNome" placeholder="Seu nome" value="{{ $user->name }}">

        <br>

        <label for="formEmail">Email</label>
        <input type="text" name="user[email]" id="formEmail" placeholder="Seu email" value="{{ $user->email }}">

        <br>

        <label for="formPhone">Telefone</label>
        <input type="text" name="buyer[phone][ddd]" id="formPhone" placeholder="Seu telefone" value="{{ $buyer !== null ? substr($buyer->phone, 0, 2) : '' }}">
        <input type="text" name="buyer[phone][number]" id="formPhone" placeholder="Seu telefone" value="{{ $buyer !== null ? substr($buyer->phone, 2) : '' }}">

        <br>

        <label for="formCpf">CPF</label>
        <input type="text" name="user[cpf]" id="formCpf" placeholder="Seu CPF" value="{{ $user->cpf }}">

        <br>

        <label for="formBirth">Data de nascimento</label>
        <input type="date" name="buyer[birth]" id="formBirth" placeholder="Seu email" value="{{ $buyer->birth ?? '' }}">

        <br>

        <button type="submit">
            Salvar alterações
        </button>

    </form>
</div>

<div>
    <h3>Senha</h3>

    @if ($passwordIsNull)
        <p>Você se logou com rede social, aproveite e crie uma senha segura para habilitar login com email.</p>
    @endif

    <form method="post" action="{{ route('profile.password') }}">

        {!! csrf_field() !!}

        @if (!$passwordIsNull)
        <label for="formSenha">Senha atual</label>
        <input type="text" name="password" id="formSenha" placeholder="Senha atual">

        <br>
        @endif

        <label for="formNovaSenha">Nova senha</label>
        <input type="text" name="new_password" id="formNovaSenha" placeholder="Nova senha">

        <br>

        <label for="formConfirmarSenha">Confirmar nova senha</label>
        <input type="text" name="confirm_password" id="formConfirmarSenha" placeholder="Confirmar nova senha">

        <br>

        <button type="submit">
            Salvar nova senha
        </button>

    </form>
</div>

@endsection