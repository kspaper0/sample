@extends('layouts.default')

@section('content')
<div class="jumbotron">
    <h1>Home Page</h1>
    <p class="lead">
        lorem..
    </p>
    <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">
            Sign Up
        </a>
    </p>
</div>

@stop