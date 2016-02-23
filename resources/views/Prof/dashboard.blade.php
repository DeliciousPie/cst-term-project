@extends('layouts.app')
@section('title')
        <title>Professor Dash Board</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/') }}">Professor Dash Board </a>
@stop


@section('bodyHeader')
        <h1>
            Professor Dash Board
        </h1>
@stop
@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Prof Dashboard</div>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
