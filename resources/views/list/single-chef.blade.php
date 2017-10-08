@extends('layouts.default')
@section('content')

<section id="single-chef-page" class="list-chefs">
    <section class="chef-header" style="background-color: white;">
        <div class="container generic__wrapper">
            <div class="row">
                <div class="col-md-3 col-lg-2">
                    <div class="chef-item__photo mr-3">
                        {{-- <img src="https://graph.facebook.com/10154279898587202/picture?type=large" class="rounded-circle" width="150" height="150"> --}}
                        <img class="rounded-circle" src="{{ $seller->seller->data['avatar'] ?? $seller->avatar_full_url }}" width="150" height="150" style="background-color: #E9EBEE;">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <h3>{{ $seller->seller->data['title'] ?? $seller->name }}</h3>
                    @if ($seller->distance)
                        <div class="chef-item__distance"><small class="text-uppercase">A {{$seller->distance}} Km de distância</small></div>
                    @endif

                    <p>{{ $seller->seller->data['description'] ?? '......' }}</p>
                </div>
                <div class="col-md-3 col-lg-4">
                    {{-- Avaliação --}}
                </div>
            </div>
        </div>

    </section>

    <div class="chefs-list">
        <div class="container generic__wrapper">
            <div class="header mb-3">
                <h2>Cardápio</h2>
            </div>
            <single-chef :seller="{{ $seller }}" :moip="{{ $moipseller }}" :settings="{{ $settings }}"></single-chef>
        </div>
    </div>

</section>

@endsection

@section('script')
<script>
    var SingleChefsPage = new Vue({
        el: '#single-chef-page',
        data: {}
    });
</script>
@endsection
