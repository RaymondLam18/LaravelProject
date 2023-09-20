@extends('layouts.web')

@section('PageTitle', 'Home')
@section('content')
    <body>
    <h1>Home</h1>
    <p>{{$text}}</p>
    <a href="{{ url('/about') }}">Go to About</a>
@endsection
