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
                <h2>Single</h2>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 col-lg-6">
                <div class="chef-item__box">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="chef-item__photo mr-3">
                            <img src="https://graph.facebook.com/10154279898587202/picture?type=large" class="rounded-circle" width="70" height="70">
                        </div>
                        <div class="chef-item__text ">
                            <div class="chef-item__title text-uppercase">Tassiana Oliveiras</div>
                            <div class="chef-item__distance"><small class="text-uppercase">A 1.3 Km de distância</small></div>
                        </div>
                        <div class="chef-item__icon-arrow ml-auto"><i class="fa fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


</section>


@endsection