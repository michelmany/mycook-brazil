@extends('layouts.default')
@section('title', 'Contato')
@section('content')

    <section class="hero-pages" 
        style="background-image: url('/assets/img/hero-04.jpg')"">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <section class="contato">

        <div class="contato__header">
            <div class="container">
                <div class="contato__headline">Alguma dúvida, reclamação ou sugestão?<br>
                    Queremos ouvir você!</div>
            </div>
            </div>

            <div class="contato__form generic__wrapper bg-color-gray">


                <form action="{{ route('contatoPost') }}" method="post">
                    {{ csrf_field() }}
                    <div class="container">

                        <div class="row">

                            <div class="col-md-8">

                                @if (count($errors) > 0)
                                    <div class="text-warning">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <input type="text" name="sender_name" placeholder="Nome" value="{{ old('sender_name') }}"
                                                @if ($errors->has('sender_name')) autofocus @endif
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                            <div class="mb-2">
                                                <input type="email" name="sender_mail" placeholder="Email" value="{{ old('sender_mail') }}"
                                                @if ($errors->has('sender_mail')) autofocus @endif
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" name="subject" placeholder="Assunto" value="{{ old('subject') }}"
                                                @if ($errors->has('subject')) autofocus @endif
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="">
                                                <textarea name="message" class="form-control form-control-lg input__entrar input__entrar--textarea" 
                                                @if ($errors->has('message')) autofocus @endif
                                                placeholder="Mensagem" required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-submit-green btn-lg" type="submit">Enviar mensagem</button>
                                </div>

                            </div>

                            <div class="col-md-4 d-flex align-items-center">
                                <div class="contato__contatos mx-lg-auto">
                                    <p>Ou entre em contato pelo Whatsapp<br>Segunda a sábado: 11h as 20h</p>
                                    <div class="contato__whatsapp">
                                        <img src="/assets/img/icon-whatsapp.png"> <a href="tel:21991330236">(21) 99133-0236</a>
                                    </div>
                                    <div class="">
                                        <a href="mailto:contato@mycook.com.br" target="_top">contato@mycook.com.br</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

    </section>


@endsection