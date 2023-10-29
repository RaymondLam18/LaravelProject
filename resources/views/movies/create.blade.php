@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="h5 fw-bold text-center">Create Movie</div>
                <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data">
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

                    <label for="image">Image</label>
                    <input id="image" type="file" class="form-control @error('description')is-invalid @enderror" name="image" value="{{old('image')}}">
                    @error('image')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                    <div>
                        Tags
                    </div>
                    @foreach(\App\Models\Tag::all() as $tag)
                        <div class="form-check">
                            <label for="{{$tag->genre}}" class="form-check-label">{{$tag->genre}}</label>
                            <input id="{{$tag->genre}}" type="checkbox" class="form-check-input @error($tag->genre)is-invalid @enderror" name="{{$tag->genre}}" value="{{$tag->id}}">
                        </div>
                        @error($tag->genre)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    @endforeach

                    <label for="description">Description</label>
                    <input id="description" type="text" class="form-control @error('description')is-invalid @enderror" name="description" value="{{old('description')}}">
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

