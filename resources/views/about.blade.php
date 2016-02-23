@extends('layouts.app')

@section('title')
        <title>About Us</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/home') }}">Curricular Densitometer   </a>
@stop

@section('bodyHeader')
<div>
    
    <h1 class="page-header"> About Us </h1>
    
</div>

@endsection

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">About</div>

                <div class="panel-body">
                    <div>
                    <h2>About</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection