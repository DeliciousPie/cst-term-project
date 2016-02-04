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
                            <button type="button" class="btn btn-default" style="width:31%" data-toggle="modal" data-target="#myModal">Add Activity</button>
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

<!-- The modal for adding an activity -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="color:black">
            <form method="POST">
                <input type="hidden" name='_token' value="{!! csrf_token() !!}">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="modal-header">
                    <h3 class="modal-title">Add Activity</h3>
                </div>
                <div class="modal-body center-block">
                    <label for="activityName">Activity Name</label>
                    <div class="input-group" style="width:100%">
                        <input id="activityName" class="form-control" name="activityName" type="text" placeholder="Activity Name" style="width:100%">
                    </div>
                    <br>
                    <label for="workload">Workload(hr)</label>
                    <br>
                    <h6>The estimated amount of time needed to finish the activity, in hours.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="workload" class="form-control" name="workload" type="number" min="1" max="800" style="width:100%">
                    </div>
                    <br>
                    <label for="stresstimate">Stresstimate</label>
                    <br>
                    <h6>Stress Estimate - 1 is the lowest, 10 is the highest.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="stresstimate" class="form-control" name="stresstimate" type="number" min="1" max="10" style="width:100%"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="Submit" formethod="POST" class="btn btn-info pull-right">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection