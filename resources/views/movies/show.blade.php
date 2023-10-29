@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="movies">
                    @include('partials.movie')
                </div>
                @auth
                    @if(auth()->user()->movies()->count() >= 5)
                        <form class="m-md-5" method="POST" action="{{ route('comments.store', $movie->id) }}" enctype="multipart/form-data">
                            @csrf
                            <label for="description">Description</label>
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}">
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="btn btn-primary">
                                Post comment
                            </button>
                        </form>
                    @else
                        <div class="m-md-5">
                            <span class="text-danger">You can only post a comment after having posted 5 movies.</span>
                        </div>
                    @endif
                @else
                    <div class="m-md-5">
                        <span class="text-danger">You need to log in to post a comment.</span>
                    </div>
                @endauth
                <div>
                    @foreach($movie->comments()->get() as $comment)
                        @include('partials.comment')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

