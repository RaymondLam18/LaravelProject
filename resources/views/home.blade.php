@extends('layouts.web')

    @section('PageTitle', 'Home | ')
    @section('content')
<body>
    <p>{{$text}}</p>
    <a href="{{ url('/about') }}">Go to About</a>
    @endsection
