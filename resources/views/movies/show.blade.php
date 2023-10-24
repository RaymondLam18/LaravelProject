@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="posts">
                    @include('partials.movie')
                </div>
                <form class="m-md-5" method="POST" action="{{ route('comments.store', $movie->id) }}" enctype="multipart/form-data">
                    @csrf
                    <label for="title">Title</label>
                    <input id="title" type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{old('title')}}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                    <label for="director">Director</label>
                    <input id="director" type="text" class="form-control @error('director')is-invalid @enderror" name="director" value="{{old('director')}}">
                    @error('director')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

{{--                    <label for="genre">Genre</label>--}}
{{--                    <input id="genre" type="text" class="form-control @error('genre')is-invalid @enderror" name="genre" value="{{old('genre')}}">--}}
{{--                    @error('genre')--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{$message}}--}}
{{--                    </div>--}}
{{--                    @enderror--}}

                    <label for="description">Description</label>
                    <input id="description" type="text" class="form-control @error('description')is-invalid @enderror" name="description" value="{{old('description')}}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                    <button type="submit" class="btn btn-primary">
                        Post comment
                    </button>
                </form>
                <div>
                    @foreach($movie->comments()->get() as $comment)
                        @include('partials.comment')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
