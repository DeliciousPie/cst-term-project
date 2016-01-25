@extends('layouts.app')

@section('title')
        <title>Home Page</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/home') }}">Home Page </a>
@stop

@section('bodyHeader')
<div>
    
    <h1 class="page-header"> Home Page </h1>
    
</div>

@endsection

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Home</div>

                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
