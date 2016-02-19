@extends('layouts.app')

@section('title')
        <title>Curricular Developer Dash Board</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/') }}">Curricular Developer Dash Board </a>
@stop


@section('bodyHeader')
        <h1>
            CD Dash Board
        </h1>
@stop

@section('content')
    @include('CD.dashboardCustomChart')
@endsection

