@extends('layouts.default')
@section('title', 'Termos e condições de uso')
@section('content')

    <section class="hero-pages" 
        style="background-image: url('/assets/img/hero-03.jpg')">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>

    <section class="termos">
        <div class="container generic__wrapper">
            @include('./partials/termos')
        </div>
    </section>



@endsection