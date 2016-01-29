@extends('layouts.app')

@section('title')
<title>Curricular Developer Activity Manager</title>
@stop

@section('navBarHeader')
<a class="navbar-brand" href="{{ url('/') }}">Curricular Developer Activity Manager </a>
@stop


@section('bodyHeader')
<br>
@stop


@section('content')
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">


                <div class="row">
                    <form method="post" action=''>
                        <input type="hidden" name='_token' value="{!! csrf_token() !!}">
                        @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <!--Left Spacing-->
                        <div class="col-md-1">
                        </div>

                        <!--Professor Select Box-->
                        <div class="col-md-3">
                            <h2>Professors</h2>

                            <select multiple class="form-control" style="height:500px">
                                    
                            </select>
                        </div>

                        <!--Middle Spacing-->
                        <div class="col-md-1">
                        </div>

                        <!--Assignment Select-->
                        <div class="col-md-6">
                            <h2>Assigned Courses</h2>

                            <select multiple class="form-control" style="height:232px">
                            </select>

                            <!--Assignments Select Box-->
                            <h2>Activities</h2>
                            <button type="button" class="btn btn-default" style="width:31%">Add Activity</button>
                            <button type="button" class="btn btn-default" style="width:31%">Edit Activity</button>
                            <button type="button" class="btn btn-default" style="width:31%">Delete Activity</button>
                            <!--Assignment Select-->
                            <br><br>
                            <select multiple class="form-control" style="height:150px">
                            </select>
                        </div>
                        <!--Right Spacing-->
                        <div class="col-md-1">
                        </div>
                </div>
                </form>





                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection