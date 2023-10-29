@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div id="movies" class="col-md-8" >
                <div class="h5 fw-bold text-center">Movies</div>
                @foreach($movies as $movie)
                    @include('partials.movie')
                @endforeach
            </div>
        </div>
    </div>

@endsection
