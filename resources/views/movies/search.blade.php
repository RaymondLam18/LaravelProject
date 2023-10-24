@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div id="posts" class="col-md-8" >
                @foreach($movies as $movie)
                    @include('partials.movie')
                @endforeach
            </div>
        </div>
    </div>

@endsection
