@extends('layouts.default')
@section('title', 'Registrar')
@section('content')

<section class="profile">
    <div class="container generic__wrapper">
        <div class="header">
            <div>
                <h2><i class="fa fa-user" aria-hidden="true"></i> Meu perfil</h2>
                <h6>Edite seu perfil</h6>
            </div>
        </div>
        <hr>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (Auth::user()->social)
            <img src="https://graph.facebook.com/{{ Auth::user()->social->provider_user_id }}/picture?type=large" 
                 class="rounded-circle ml-2" width="150" height="150">
        @else 
             @if ($user->avatar_full_url)
                 <avatar photo-url="{{ $user->avatar_full_url }}"></avatar>
             @endif
        @endif

        <div>
                <div class="row">

                    <div class="col-md-6">
                     <h5 class="mb-3 bg-faded p-3">Informações pessoais</h5>

                     <form method="post" action="{{ route('profile.post') }}">

                         {!! csrf_field() !!}

                        <div class="form-group">

                            <input type="text" name="user[name]" id="formNome"
                                class="form-control form-control-lg input__entrar" placeholder="Seu nome" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">

                            <input type="text" name="user[email]" id="formEmail" 
                                class="form-control form-control-lg input__entrar bg-faded" placeholder="Seu email" value="{{ $user->email }}" readonly="readonly">
                        </div>

                        <div class="form-group row">
                            <div class="col-6">

                                <input type="text" name="buyer[phone][ddd]" id="formPhone" class="form-control form-control-lg input__entrar" placeholder="Seu telefone" value="{{ $buyer !== null ? substr($buyer->phone, 0, 2) : '' }}">
                            </div>
                            <div class="col-6">

                                <input type="text" name="buyer[phone][number]" id="formPhone" class="form-control form-control-lg input__entrar" placeholder="Seu celular" value="{{ $buyer !== null ? substr($buyer->phone, 2) : '' }}">
                            </div>
                        </div>
                
                        <div class="form-group">

                            <input type="text" name="user[cpf]" id="formCpf"
                                class="form-control form-control-lg input__entrar" placeholder="Seu CPF" value="{{ $user->cpf }}">
                        </div>

                        <div class="form-group">

                            <input type="text" name="buyer[birth]" id="formBirth" 
                                class="form-control form-control-lg input__entrar" placeholder="Data de nascimento" value="{{ $buyer->birth ?? '' }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit-orange">
                                Salvar alterações
                            </button>
                        </div>
                    </div><!-- /col-md-6 -->

                </form>

                    <div class="col-md-6">
                    <h5 class="mb-3 bg-faded p-3">Senha</h5>

                        @if ($passwordIsNull)
                            <p>Você se logou com facebook, aproveite e crie uma senha segura para habilitar login com email.</p>
                        @endif

                        <form method="post" action="{{ route('profile.password') }}">

                            {!! csrf_field() !!}

                            @if (!$passwordIsNull)
                                <div class="form-group">
                                    <input type="text" name="password" id="formSenha" 
                                        class="form-control form-control-lg input__entrar" placeholder="Senha atual">
                                </div>
                            @endif
                                <div class="form-group">
                                    <input type="text" name="new_password" id="formNovaSenha" 
                                    class="form-control form-control-lg input__entrar" placeholder="Nova senha">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="confirm_password" id="formConfirmarSenha" 
                                        class="form-control form-control-lg input__entrar" placeholder="Confirmar nova senha">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-submit-orange">
                                        Salvar nova senha
                                    </button>
                                </div>

                        </form>
                    </div>

                </div><!-- /row -->


    </div><!-- /container -->
</section>




@endsection