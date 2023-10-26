<div class="card m-md-5">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <img class="profile-image" src="{{url("/img/users/" . $movie->user->profile_picture)}}" alt="Profile picture of the user">
                <div class="m-3 h5">{{$movie->user->name}}</div>
            </div>
            <div>
                @auth
                    @if($movie->user->id == auth()->user()->id)
                        <a class="btn @if($movie->status) btn-secondary @else btn-outline-secondary @endif" href="{{route('movies.status', $movie->id)}}"
                           onclick="event.preventDefault();
                                                     document.getElementById('{{$movie->id}}STAT').submit();">
                            @if($movie->status) Active @else Inactive @endif
                        </a>
                        <a class="btn btn-primary" href="{{route('movies.edit', $movie->id)}}">Edit</a>
                        <a class="btn btn-danger" href="{{ route('movies.destroy', $movie->id) }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('{{$movie->id}}DEL').submit();">
                            Delete
                        </a>
                        <form id="{{$movie->id}}DEL" action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                        <form id="{{$movie->id}}STAT" action="{{ route('movies.status', $movie->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('PATCH')
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="content">{{$movie->title}}</div>
        <div class="content">{{$movie->director}}</div>
        @if($movie->image)
            <img class="img-fluid" src="{{url("/img/movies/" . $movie->image)}}" alt="Image of the movie">
        @endif
{{--        <div class="content">{{$movie->genre}}</div>--}}
        <div class="content">{{$movie->description}}</div>
    </div>
    @if($movie->tags()->exists())
        <div class="card-body">
            @foreach($movie->tags()->get() as $tag)
                <a href="{{route('movies.search', 'tags=' . $tag->id)}}" class="btn btn-outline-primary">{{$tag->genre}}</a>
            @endforeach
        </div>
    @endif
    <div class="card-footer d-flex justify-content-between">
        <a class="btn btn-primary" href="{{route('movies.show', $movie->id)}}">
            Comments: {{$movie->comments()->count()}}
        </a>
        <div class="fw-bold">{{$movie->created_at}}</div>
    </div>
</div>
