@extends('layouts.maintenance')
@section('title', 'Home')
@section('content')

<style>

@media screen and (min-width: 768px) {
    .hero-image__headline {
        font-size: 36px;
        line-height: 40px;
        margin-bottom: 30px;
    }
}

</style>

    <section class="hero-image" style="background-image: url('/assets/img/hero-image-01.jpg')">
        <div class="hero-image__mask"></div>

        <div class="hero-image__content">
            <div class="hero-image__headline">Agora falta muito pouco, para você ter acesso a melhor plataforma de comida caseira e artesanal, com preço justo do Brasil!</div>
            <div class="hero-image__subline">Lançamento em breve, aguarde!</div>
        </div>
 
    </section>

@endsection

@section('script')
    <script>
        var queryHome = new Vue({
            el: '#queryHome'
        });

        // Hero fill browser window
        var heroImage = $('.hero-image');
        var heroImageMask = $('.hero-image__mask');
        var win = $(window);
        resizeHero();
        //reload only if width size changes
        var width = $(window).width();
        win.on('resize', function(){
            if($(this).width() != width){
                resizeHero();
            }
        });
        function resizeHero() {
            if (win.width() > 320 && win.width() < 1920) {
                heroImage.height(win.height() - 96);
                heroImageMask.height(win.height() - 96);
            } else {
                heroImage.css('height', '');
                heroImageMask.css('height', '');
            }
        }
    </script>
@endsection