@extends('layouts.web')

@section('PageTitle', 'About')
@section('content')
    <body>
    <h1>About</h1>
    <p>{{$text}}</p>
    <a href="{{ url('/home') }}">Go to Home</a>
@endsection
