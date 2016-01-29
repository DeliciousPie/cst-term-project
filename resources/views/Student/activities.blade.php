@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="panel-heading">
                <h3 class="panel-title">
                 <i class="fa fa-bar-chart-o fa-fw"></i>Student Activites</h3>
            </div>
            
            @if( isset($studentActivities) && count($studentActivities)>0)
            
                <!--This is  a for each loop that will iterate through all of 
                 the activities a user has tied to it's name/id-->
                @foreach($studentActivities as $studAct)


                    <!-- This will show the name of the activity the user needs
                     to record-->
                    @section('ActivityName', $studAct['activityID'])

                    <!--This will in include the Classes section which will 
                    take in the variables below in the order listed below. DO 
                    NOT mix it up!-->
                    @include('student.activity')

                @endforeach
            @else
            
            <p> No activities</p>
             
            @endif
            
            </div>
        </div>
    </div>
</div>
@endsection