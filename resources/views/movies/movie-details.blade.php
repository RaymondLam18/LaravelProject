@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div id="movies" class="col-md-8" >
                <div class="h5 fw-bold text-center">Details</div>
                <div class="card m-md-5">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <img class="profile-image" src="{{url("/img/users/" . $movie->user->profile_picture)}}" alt="Profile picture of the user">
                                <div class="m-3 h5">{{$movie->user->name}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="m-3 h5">
                            <label for="movie-title" class="title-label">Title:</label>
                            <span id="movie-title"><strong>{{$movie->title}}</strong></span>
                        </div>
                        <div class="m-3 h5">
                            <label for="movie-director" class="title-label">Director:</label>
                            <span id="movie-director"><strong>{{$movie->director}}</strong></span>
                        </div>
                        @if($movie->image)
                            <img class="img-fluid" src="{{url("/img/movies/" . $movie->image)}}" alt="Image of the movie">
                        @endif
                        <div class="content">{{$movie->description}}</div>
                        @if($movie->tags()->exists())
                            <div class="card-body">
                                @foreach($movie->tags()->get() as $tag)
                                    <a href="{{route('movies.search', 'tags=' . $tag->id)}}" class="btn btn-outline-primary">{{$tag->genre}}</a>
                                @endforeach
                            </div>
                        @endif
                        <div class="card-footer d-flex justify-content-between">
                            <div class="fw-bold">Comments: {{$movie->comments()->count()}}</div>
                            <div class="fw-bold">{{$movie->created_at}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
