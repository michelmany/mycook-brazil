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
            <input id="cep_field" type="number" name="address[cep]" placeholder="CEP" value="{{old('cep')}}">
            @include('components.error', ['field'=>'cep'])
        </div>

        <div>
            <input id="address_field" type="text" name="address[address]" placeholder="Endereço completo" value="{{old('address')}}">
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
            <input id="neighborhood_field" type="text" name="address[neighborhood]" placeholder="Bairro" value="{{old('neighborhood')}}">
            @include('components.error', ['field'=>'neighborhood'])
        </div>

        <div>
            <input id="city_field" type="text" name="address[city]" placeholder="Município" value="{{old('city')}}">
            @include('components.error', ['field'=>'city'])
        </div>

        <div>
            <input id="state_field" type="text" name="address[state]" placeholder="UF" value="{{old('state')}}">
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
            <label for="buyerFormacao">Formação</label>
            <select name="buyer[formacao]" id="buyerFormacao">
                <option disabled selected>Escolha</option>
                <option value="formacao1">Formação 1</option>
                <option value="formacao2">Formação 2</option>
            </select>
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

        <div>
            <textarea name="buyer[dishes]" placeholder="Quais pratos deseja vender no mycook?">{{old('name')}}</textarea>
            @include('components.error', ['field'=>'name'])
        </div>

        <div>
            <p>Você cozinha?</p>
            <input type="checkbox" name="buyer[type_delivery][]" value="Sob encomenda">Sob encomenda<br>
            <input type="checkbox" name="buyer[type_delivery][]" value="Pronta entrega">Pronta entrega
            @include('components.error', ['field'=>'name'])
        </div>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
        // TODO: criar isso com mais calma

        let callApi = (url) => {
          return new Promise((resolve, reject) => {
            let xhr;
            xhr = new XMLHttpRequest();
            xhr.onload = () => {
              if (xhr.status >= 200 && xhr.status <= 300){
                resolve(xhr.responseText);
              } else {
                reject(xhr.status, xhr.statusText)
              }
            }
            xhr.onerror = () => {
              reject(xhr.status, xhr.statusText)
            }
            xhr.open("GET", url, true);
            xhr.send();
          })
        }

        let cep = document.getElementById('cep_field');
        cep.addEventListener('change', () => {
          if (cep.value.length !== 8) {
            return;
          }
          let url = 'https://viacep.com.br/ws/' + cep.value + '/json/';
          callApi(url)
          .then((res) => {
            res = JSON.parse(res);
            let address = document.getElementById('address_field');
            let neighborhood = document.getElementById('neighborhood_field');
            let city = document.getElementById('city_field');
            let state = document.getElementById('state_field');

            address.value = res.logradouro;
            neighborhood.value = res.bairro;
            city.value = res.localidade;
            state.value = res.uf;
          })
          .catch((status) => {
            console.log('erro ' + status);
          });
        });


    </script>

@endsection