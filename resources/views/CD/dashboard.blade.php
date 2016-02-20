@extends('layouts.app')

@section('title')
        <title>Curricular Developer Dash Board</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/') }}">Curricular Developer Dashboard </a>
@stop


@section('bodyHeader')
        <h1>
            Welcome {{Auth::user()->name}}!
        </h1>
@stop

@section('content')   
    @include('CD.dashboardCustomChart')
@endsection

