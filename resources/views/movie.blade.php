@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Movies') }}</div>

                    <div class="card-body">
                        <table>
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Director</th>
                                <th>Genre</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($movies as $movie)
                                    <tr>
                                        <td>{{ $movie -> title }}</td>
                                        <td>{{ $movie -> director }}</td>
                                        <td>{{ $movie -> genre }}</td>
                                        <td>{{ $movie -> description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
