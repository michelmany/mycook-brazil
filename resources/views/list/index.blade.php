@extends('layouts.default')
@section('content')

<section id="list-chefs-page" class="list-chefs">

    <div class="search-chef">
        <div class="container">
            <form class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></div>
                  <input type="search" class="form-control form-control-lg input__entrar" id="search-chef" placeholder="Buscar Chef">
              </div>
          </form>
      </div>
  </div>

  <div class="filter">

  </div>

  <div class="chefs-list">
    <div class="container generic__wrapper">
        <div class="header mb-3">
            <div>
                <h2>Chefs</h2>
            </div>
        </div>      
        @if (isset($latitude))
            <list-chefs :latitude="{{ $latitude }}" :longitude="{{ $longitude }}"></list-chefs>
        @else
            <list-chefs></list-chefs>
        @endif

    </div>
</div>


</section>


@endsection


@section('script')
    <script>
        var ListChefsPage = new Vue({
            el: '#list-chefs-page'
        });
    </script>
@endsection