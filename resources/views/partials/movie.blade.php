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
        <div class="m-3 h5">
            <!-- Add a bold label for the title -->
            <label for="movie-title" class="title-label">Title:</label>
            <span id="movie-title"><strong>{{$movie->title}}</strong></span>
        </div>
        <div class="m-3 h5">
            <!-- Add a bold label for the director -->
            <label for="movie-director" class="title-label">Director:</label>
            <span id="movie-director"><strong>{{$movie->director}}</strong></span>
        </div>
        @if($movie->image)
            <img class="img-fluid" src="{{url("/img/movies/" . $movie->image)}}" alt="Image of the movie">
        @endif
    </div>
    <div class="card-footer d-flex justify-content-between">
        <a class="btn btn-primary" href="{{route('movies.show', $movie->id)}}">Comment</a>
        <a class="btn btn-secondary" href="{{route('movies.details', $movie->id)}}">Details</a>
    </div>
</div>
