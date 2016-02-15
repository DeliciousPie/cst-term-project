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
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">CD Dashboard</div>

                <div class="panel-body">

                   <div id="pop_div1"></div> 
                   <div id="pop_div2"></div>
                   <div id="pop_div3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@columnchart('Student Time','pop_div1')
@columnchart('Student Stress','pop_div2')
@piechart('Course Time', 'pop_div3')
@endsection