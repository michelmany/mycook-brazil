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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="mb-2">
                                                <input type="text" name="sender_name" placeholder="Nome" value=""
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" name="sender_mail" placeholder="Email" value=""
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" name="subject" placeholder="Assunto" value=""
                                                class="form-control form-control-lg input__entrar" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="">
                                                <textarea name="message" class="form-control form-control-lg input__entrar input__entrar--textarea" placeholder="Mensagem" required></textarea>
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
                                        <img src="/assets/img/icon-whatsapp.png"> (21) 2200-0000
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div>

    </section>


@endsection