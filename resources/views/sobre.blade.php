@extends('layouts.default')
@section('title', 'Sobre')
@section('content')

    <section class="hero-pages" 
        style="background-image: url('/assets/img/hero-02.jpg')"">
        <div class="hero-pages__mask"></div>
        <div class="container">
            <div class="hero-pages__headline ml-auto">@yield('title')</div>
        </div>
    </section>


@endsection