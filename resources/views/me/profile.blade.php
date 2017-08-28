@extends('layouts.default')
@section('title', 'Registrar')
@section('content')

<section id="profile" class="profile">
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

{{--         @if (Auth::user()->social)
            <img src="https://graph.facebook.com/{{ Auth::user()->social->provider_user_id }}/picture?type=large" 
                 class="rounded-circle ml-2" width="150" height="150">
        @else 
             @if ($user->avatar_full_url)
                 <avatar photo-url="{{ $user->avatar_full_url }}"></avatar>
             @endif
        @endif --}}

        <div>
                <div class="row">

                    <div class="col-md-6">
                        <h5 class="mb-3 bg-faded p-3">Informações pessoais</h5>

                        <profile-dados :user="{{ $user }}" :buyer="{{ $buyer }}"></profile-dados>

                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3 bg-faded p-3">Senha</h5>

                        <profile-senha password-is-null="{{ $passwordIsNull }}"></profile-senha>
                            
                    </div>

                </div><!-- /row -->


    </div><!-- /container -->
</section>

@endsection

@section('script')
    <script>
        const profile = new Vue({
            el: '#profile'
        });
    </script>
@endsection