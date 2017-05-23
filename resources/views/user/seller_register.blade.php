@extends('layouts.default')
@section('title', 'Quero vender no mycook')
@section('content')

<section class="hero-pages" 
    style="background-image: url('/assets/img/hero-05.jpg')"">
    <div class="hero-pages__mask"></div>
    <div class="container">
        <div class="hero-pages__headline ml-auto">@yield('title')</div>
    </div>
</section>

<section class="quero-vender generic__wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="generic__headline">Alguns dos benefícios em fazer parte do mycook.</div>
                <ul class="generic__list">
                    <li>Faça a sua agenda com os dias e horários que deseja vender os seus produtos no mycook, de acordo com a sua disponibilidade.</li>
                    <li>Você decide a quantidade de produtos que deseja vender por dia.</li>
                    <li>Você só paga para a mycook, se o seu produto for vendido.</li>
                    <li>Ser o seu próprio chefe e trabalhar por conta própria, com o mycook é possível!</li>
                    <li>Queremos aumentar a visibilidade do seu negocio, através de investimentos de marketing, promoção e publicidade.</li>
                </ul>
                <a href="#form-chef" class="btn btn-outline-primary feature__read-more generic__button--black-outline">Cadastrar agora</a>
            </div>
            <div class="offset-md-1 col-md-5 d-flex align-items-center">
                <div class="quero-vender__image-container d-flex">
                    <img src="/assets/img/sobre-01.jpg" 
                        class="quero-vender__image img-fluid align-self-center">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="form-chef" class="form-chef generic__wrapper">
    <div class="form-chef__head text-center">
        <div class="container">
            <div class="form-chef__headline">Seja muito bem-vindo ao mycook!</div> 
            <div class="form-chef__copy">
                <p>Será um prazer enorme ter você em nossa plataforma.
                Para vender no mycook, preencha o formulário abaixo e aguarde nosso contato.</p>
                <p>Se tudo estiver ok com o seu cadastro, você receberá um e-mail informando que o seu cadastro foi disponibilizado.</p>
                <p>Pronto! Você já poderá começar a vender os seus produtos no mycook.</p>
            </div>
        </div>
    </div>

    <div class="form-chef__errors">
        @include('components.error', ['field'=>'name'])
        @include('components.error', ['field'=>'cpf'])
        @include('components.error', ['field'=>'cep'])
        @include('components.error', ['field'=>'number'])
        @include('components.error', ['field'=>'address'])
        @include('components.error', ['field'=>'complement'])
        @include('components.error', ['field'=>'neighborhood'])
        @include('components.error', ['field'=>'city'])
        @include('components.error', ['field'=>'state'])
        @include('components.error', ['field'=>'email'])
        @include('components.error', ['field'=>'phone'])
        @include('components.error', ['field'=>'formacao'])
        @include('components.error', ['field'=>'facebook'])
        @include('components.error', ['field'=>'instagram'])
        @include('components.error', ['field'=>'name'])
    </div>

    <div id="preloader" class="form_seller_hidden">
        <div>
            Enviando...
        </div>
    </div>

    <div class="form-chef__form">
        <form id="formCadastroVendedor" action="{{ route('queroVenderPost') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="container">

                <div class="form-group row">
                    <div class="col-lg-7">
                        <input type="text" name="user[name]" placeholder="Nome completo" value="{{old('name')}}" 
                            class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-5">
                        <input type="text" name="user[cpf]" placeholder="CPF" value="{{old('cpf')}}" 
                            class="form-control form-control-lg input__entrar" required>
                    </div>
                </div>

                <div class="form-group row">
                <div class="col-lg-3">
                    <input id="cep_field" type="number" name="address[cep]" placeholder="CEP" value="{{old('cep')}}"
                        class="form-control form-control-lg input__entrar" required>
                </div>
                    <div class="col-lg-6">
                        <input id="address_field" type="text" name="address[address]" placeholder="Endereço completo" 
                        value="{{old('address')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" name="address[number]" placeholder="Número" value="{{old('number')}}"
                            class="form-control form-control-lg input__entrar" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-4">
                        <input type="text" name="address[complement]" placeholder="Complemento" 
                            value="{{old('complement')}}" class="form-control form-control-lg input__entrar">
                    </div>
                    <div class="col-lg-3">
                        <input id="neighborhood_field" type="text" name="address[neighborhood]" placeholder="Bairro" 
                            value="{{old('neighborhood')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-3">
                        <input id="city_field" type="text" name="address[city]" placeholder="Município" 
                            value="{{old('city')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-2">
                        <input id="state_field" type="text" name="address[state]" placeholder="UF" 
                            value="{{old('state')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-3">
                        <input type="email" name="user[email]" placeholder="Email" 
                            value="{{old('email')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" name="buyer[phone]" placeholder="Telefone" 
                            value="{{old('phone')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-3">
                        <select name="buyer[formacao]" id="buyerFormacao" class="form-control form-control-lg input__entrar input__entrar--select" required>
                            <option disabled selected>Sua Formação</option>
                            <option value="formacao1">Formação 1</option>
                            <option value="formacao2">Formação 2</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" name="buyer[facebook]" placeholder="Facebook" 
                            value="{{old('facebook')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" name="buyer[instagram]" placeholder="Intagram" 
                            value="{{old('instagram')}}" class="form-control form-control-lg input__entrar" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-5">
                        <textarea name="buyer[dishes]" class="form-control form-control-lg input__entrar input__entrar--textarea"
                            placeholder="Quais pratos deseja vender no mycook?" rows="6" required>{{old('dishes')}}</textarea>
                    </div>
                    <div class="col-lg-3 mt-3">
                        <label class="form-chef__label">Você cozinha?</label>
                        <p><small>Caso faça ambos, selecione as duas caixas</small></p>
                        <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                           <label class="form-check-label">
                             <input class="form-check-input" type="checkbox" name="buyer[type_delivery][]" value="Pronta entrega" required> Pronta entrega
                           </label>
                         </div>
                        <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                           <label class="form-check-label">
                             <input class="form-check-input" type="checkbox" name="buyer[type_delivery][]" value="Sob encomenda" required> Sob encomenda
                           </label>
                         </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <label class="form-chef__label">Por favor envie três fotos do ambiente de trabalho e + três fotos dos produtos que você pretende vender.</label>
                        <span class="btn btn-file-blue btn-file">
                            Selecionar arquivos...<input type="file" name="images[estabelecimento][]" multiple required>
                        </span>
                        <p><small>Apenas imagens (JPG, PNG).</small></p>
                    </div>
                </div>
                <div class="form-check text-center">
                    <label class="form-check-label form-chef__concordo">
                        <input class="form-check-input" type="radio" name="termos">
                        Concordo com os termos de contrato.
                    </label>
                </div>
                <div class="submit-button text-center">
                    <button type="submit" class="btn btn-submit-orange btn-lg">Cadastrar</button>
                </div>
            </div>
        </form>
        <div id="salvoCadastroVendedor" class="form-chef__thank-you form_seller_hidden">
            <div class="thank-you__headline">Obrigado!</div>
            <div class="thank-you__subline">Seus dados foram enviados com sucesso!</div>
            <div class="thank-you__copy">Você receberá uma confirmação em seu email cadastrado!</div>
        </div>
    </div>

</section>

@endsection

@section('script')
    <script type="text/javascript" src="{{mix("/assets/js/vendedor.js")}}"></script>
@endsection