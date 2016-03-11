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
    <div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Select Data To View Chart</div>

                <div class="panel-body">
                    
                    <form id="customChartForm" 
                          name="customChartForm" class="activity" 
                          method="post" >
                        <input type="hidden" name="activityID" 
                               value="customChartForm"
                               method="post">   

                        <input type="hidden" name="_token" 
                               value="{!! csrf_token() !!}">
                        <label for="chartSelected">Please select a type of chart:</label>
                        <select id="chartSelected" name="chartSelected" class="form-control">
                            <option selected value="0">Select Chart</option>
                            <option value ="1">Pie</option>
                            <option value ="2">Donut</option>
                            <option value ="3">Scatter</option>
                            <option value ="4">Bubble</option>
                            <option value ="5">Column</option>
                            <option value ="6">Bar</option>
                            <option value ="7">Combo</option>
                            <option value ="8">Area</option>
                            <option value ="9">Line</option>
                        </select>
                         <br />
                        
                        <label for="classSelected"> Class: </label>
                        <br />
                        <select id="classSelected"  name="classSelected" class="form-control">
                            <option selected value="1">Select Class</option>
                            <option value= "1">All Classes</option>
                            
                            @if( isset($courses) && count($courses) > 0 )
                            
                                @foreach($courses as $course)
                                    <option>{{$course['courseID']}}</option>
                                @endforeach
                                
                            @endif
                            
                        </select>
                        <br />

                        <label for="comparison1" required> Parameter1:</label>
                        <select id="comparison1" name="comparison1" class="form-control">
                            <option selected value="spent">Select Parameter</option>
                            <option value="stressLevel">Stress Level</option> 	
                            <option value="timeSpent">Time Actual</option>	
                            <option value="timeEstimated" >Time Estimate</option>

                        </select>
                        
                         <br />
                         
                        <label for="comparison2" required> Parameter2:</label>
                        <select id="comparison2" name="comparison2" class="form-control">
                            <option selected  value="estimated">Select Parameter</option>
                            <option value="stressLevel">Stress Level</option> 	
                            <option value="timeSpent">Time Actual</option>	
                            <option value="timeEstimated" >Time Estimate</option>

                        </select>
                        
                        <br />
                        <button for="customChartForm" type="submit" value="Submit">Submit</button> 
                    </form> 
                    <br />
                    <div id="timeChart"></div>
                    
                    
                    @columnchart('StudentParam', 'timeChart')
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
