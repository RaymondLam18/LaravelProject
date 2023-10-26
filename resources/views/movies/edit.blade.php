@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('movies.update', $movie) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <label for="description">Title</label>
                    <input id="description" type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{old('title', $movie->title)}}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                    <label for="description">Director</label>
                    <input id="description" type="text" class="form-control @error('director')is-invalid @enderror" name="director" value="{{old('director', $movie->director)}}">
                    @error('director')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                    <label for="image">Image</label>
                    <input id="image" type="file" class="form-control @error('image')is-invalid @enderror" name="image" value="{{old('image', url("/img/movies/" . $movie->image))}}">

                    <img src="{{old('image', url("/img/movies/" . $movie->image))}}" alt="Picture to be uploaded">

                    @error('image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

{{--                    <label for="genre">Genre</label>--}}
{{--                    <input id="genre" type="text" class="form-control @error('genre')is-invalid @enderror" name="genre" value="{{old('genre', $movie->genre)}}">--}}
{{--                    @error('genre')--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{$message}}--}}
{{--                    </div>--}}
{{--                    @enderror--}}

                    @foreach(\App\Models\Tag::all() as $tag)
                        <div class="form-check">
                            <label for="{{$tag->genre}}" class="form-check-label">{{$tag->genre}}</label>
                            <input id="{{$tag->genre}}" type="checkbox" class="form-check-input @error($tag->genre)is-invalid @enderror" name="{{$tag->genre}}" value="{{$tag->id}}" @if(old($tag->genre)) checked @endif>
                        </div>
                        @error($tag->genre)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    @endforeach

                    <label for="description">Description</label>
                    <input id="description" type="text" class="form-control @error('description')is-invalid @enderror" name="description" value="{{old('description', $movie->description)}}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                    <button type="submit" class="btn btn-primary">
                        Post
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
