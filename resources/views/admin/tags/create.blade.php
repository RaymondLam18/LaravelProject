@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="h5 fw-bold text-center">Create Tag</div>
                <form method="POST" action="{{ route('tags.store') }}">
                    @csrf
                    <label for="genre">Genre</label>
                    <input id="genre" type="text" class="form-control @error('genre')is-invalid @enderror" name="genre" value="{{old('genre')}}">
                    @error('genre')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror

                    <button type="submit" class="btn btn-primary">
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
