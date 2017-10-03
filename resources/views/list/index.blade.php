@extends('layouts.default')
@section('content')

<section id="list-chefs-page" class="list-chefs">

    <search-chef></search-chef>

    {{-- Create filter in the future --}}
    <div class="filter"></div>

    <div class="chefs-list">
        <div class="container generic__wrapper">
            <div class="header mb-3">
                <div>
                    <h2>Chefs próximos a você</h2>
                </div>
            </div>      
        @if(session()->has('fail'))

            <p class="text-danger">{{ session()->get('fail') }}</p>
        @endif

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
            el: '#list-chefs-page',
            created() {

            }
        });
    </script>
@endsection