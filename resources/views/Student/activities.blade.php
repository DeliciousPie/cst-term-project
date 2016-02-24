@extends('layouts.app')

@section('title')
        <title>Student Activities</title>
@stop

@section('navBarHeader')
        <a class="navbar-brand" href="{{ url('/') }}">Student Activities</a>
@stop



@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
      
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart-o fa-fw"></i><h2>Student Activities</h2>
                </h3>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif       
    @if( isset($studentActivities) && count($studentActivities) > 0 )
        
            @foreach ($errors->all() as $error)
               <p class="alert alert-danger">{{ $error }}</p>
            @endforeach

            <!--This is  a for each loop that will iterate through all of 
            the activities a user has tied to it's name/id-->
            @foreach($studentActivities as $stud)
           
            <div class="row">
                <div class="col-lg-12">
                   <div class="panel panel-default" t="2">                        
                        <div class="panel-heading">
                            <div class='row'>
                                <div class="col-lg-9">
                                    <h3 class="panel-title">
                                        <i class="fa fa-bar-chart-o fa-fw">
                                           {{$stud[0]['courseID']}}
                                        </i>
                                    </h3>
                                </div>
                                <div class="col-lg-2"></div>
                                <div class="col-lg-1">
                                    <span style="font-size: 2em" class="glyphicon glyphicon-collapse-down navbar-right" 
                                        aria-hidden="false"  onclick="$('#{{$stud[0]['courseID']}}panel').toggle();">
                                    </span>
                                </div>
                            </div>
                        </div> 
                    <div class="panel-body" id="{{$stud[0]['courseID']}}panel" style="display:none">
                    @foreach( $stud as $studAct )
                        @include('student.activity')
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @endforeach
        
    @else
            
        <p>No activities</p>
             
    @endif      
            </div>
        </div>
    </div>
</div>
@endsection
