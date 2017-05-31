@extends('layouts.default')
@section('content')


    <section class="list" style="margin-top: 100px; margin-bottom: 200px;">
        <div class="container">
            @if (Auth::user()->name)
                <h1>Olá {{ Auth::user()->name }}!</h1>
            @endif
            <h4>Em breve os melhores chefs estarão disponíveis para você!</h4>
        </div>
    </section>


@endsection