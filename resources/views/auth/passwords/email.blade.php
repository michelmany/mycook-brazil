@extends('layouts.default')
@section('title', 'Recuperar senha')

@section('content')

<div class="container generic__wrapper">

    <div class="header">
        <div>
            <h2><i class="fa fa-unlock-alt" aria-hidden="true"></i> Recuperar senha</h2>
        </div>
    </div>
    <hr>

    <div class="panel panel-default">
        <div class="panel-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Digite seu E-mail</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-submit-green btn-lg">
                            Enviar link para recuperar senha
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
    <style>
        .help-block {
            font-size: 14px;
            color: red;
        }
    </style>
@endsection
