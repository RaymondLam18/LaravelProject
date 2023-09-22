@extends('layouts.web')

@section('PageTitle', 'Profile')
@section('content')
    <body>
    <h1>Profile</h1>
    <a href="{{ url('/home') }}">Go to Home</a>
    <a href="{{ url('/about') }}">Go to About</a>
@endsection
