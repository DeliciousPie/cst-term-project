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

<script>
    var rangeValues =
    {
        "0": "0/10 - Not stressed",
        "1": "1/10 - Not stressed",
        "2": "2/10 - Somewhat Stressed",
        "3": "3/10 - Somewhat Stressed",
        "4": "4/10 - Stressed",
        "5": "5/10 - Stressed",
        "6": "6/10 - Stressed",
        "7": "7/10 - Very Stressed",
        "8": "8/10 - Very Stressed",
        "9": "9/10 - Extremely Stressed",
        "10": "10/10 - Extremely Stressed"
    };

    $('#rangeText').text(rangeValues[$('#rangeInput').val()]);

    // setup an event handler to set the text when the range value is 
    // dragged (see event for input) or changed (see event for change)
    $('.stressSliders').on('input change', function () 
    {
        //Get the ID of the class moved, and change the text
        $('#' + $(this).attr('id') + "Label").text(rangeValues[$(this).val()]);
    });
    
    //For each slider
    //On page load, set the label to what the current value is
    $('.stressSliders').each(function () 
    {
        $('#' + $(this).attr('id') + "Label").text(rangeValues[$(this).val()]);
    });
</script>
@endsection
