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

                        <div id="formDiv" hidden>          
                            <label id="classSelectedLabel" for="classSelected"> Class: </label>

                            <select id="classSelected"  name="classSelected" class="form-control">
                                <option selected value="1">Select Class</option>
                                <option value= "1">All Classes</option>

                                @if( isset($courses) && count($courses) > 0 )

                                @foreach($courses as $course)
                                <option>{{$course['courseID']}}</option>
                                @endforeach

                                @endif

                            </select>

                            <div id="bubbleMultiSelect" hidden>
                                <div id="courseMultiSelect">
                                    <div id="courseFieldLabel"></div>
                                    <div id="courseField" hidden>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <select name="from[]" id="undo_redo" class="form-control" size="13" multiple="multiple">
                                                    <!--Insert options here. AKA dynamically populate the list-->
                                                </select>
                                            </div>

                                            <div class="col-xs-2">
                                                <br />
                                                <br />
                                                <!--                                    <button hidden type="button" id="undo_redo_undo" class="btn btn-primary btn-block">undo</button>-->
                                                <button type="button" name="courseRightAll" id="undo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" name="courseRight" id="undo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" name="courseLeft" id="undo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" name="courseLeftAll" id="undo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                                <!--                                    <button hidden type="button" id="undo_redo_redo" class="btn btn-warning btn-block">redo</button>-->
                                                <br />
                                            </div>


                                            <div class="col-xs-5">
                                                <select name="courseList[]" id="undo_redo_to" class="form-control" size="13" multiple="multiple">

                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                                <div id="studentMultiSelect">
                                    <div id="studentFieldLabel"></div>
                                    <div id="studentField" hidden>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <select name="from[]" id="studentundo_redo" class="form-control" size="13" multiple="multiple">
                                                    <!--Insert options here. AKA dynamically populate the list-->
                                                </select>
                                            </div>

                                            <div class="col-xs-2">
                                                <br />
                                                <br />
                                                <!--                                    <button type="button" id="studentundo_redo_undo" class="btn btn-primary btn-block">undo</button>-->
                                                <button type="button" name="studentRightAll" id="studentundo_redo_rightAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                                <button type="button" name="studentRight" id="studentundo_redo_rightSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                                <button type="button" name="studentLeft" id="studentundo_redo_leftSelected" class="btn btn-default btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                                <button type="button" name="studentLeftAll" id="studentundo_redo_leftAll" class="btn btn-default btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                                <!--                                    <button type="button" id="studentundo_redo_redo" class="btn btn-warning btn-block">redo</button>-->
                                                <br />
                                            </div>


                                            <div class="col-xs-5">
                                                <select name="studentList[]" id="studentundo_redo_to" class="form-control" size="13" multiple="multiple">

                                                </select>
                                            </div>
                                        </div>
                                        <br />
                                    </div>
                                </div>
                            </div><!-- bubble mult select-->
                            <label for="comparison1" required> Parameter 1:</label>
                            <select id="comparison1" name="comparison1" class="form-control">
                                <option selected value="spent">Select Parameter</option>
                                <option value="stressLevel">Stress Level</option> 	
                                <option value="timeSpent">Time Actual</option>	
                                <option value="timeEstimated" >Time Estimate</option>

                            </select>

                            <br />

                            <label for="comparison2" required> Parameter 2:</label>
                            <select id="comparison2" name="comparison2" class="form-control">
                                <option selected  value="estimated">Select Parameter</option>
                                <option value="stressLevel">Stress Level</option> 	
                                <option value="timeSpent">Time Actual</option>	
                                <option value="timeEstimated" >Time Estimate</option>

                            </select>
                            <br />
                            <label hidden for="comparison3" id="bubbleRadius" required>Bubble Radius:</label>
                            <select id="comparison3" name="comparison3" class="form-control">
                                <option selected value="spent">Select Parameter</option>
                                <option value="stressLevel">Stress Level</option> 	
                                <option value="timeSpent">Time Actual</option>	
                                <option value="timeEstimated" >Time Estimate</option>
                            </select> 
                            <br />
                            <button id="submitBtn" for="customChartForm" type="submit" value="Submit">Submit</button> 
                    </form> 

                </div>
                <br />
                <div id="timeChart"></div>

                @if( isset($columnChart) ) 

                @columnchart('StudentParam', 'timeChart')

                @elseif(isset($bubbleChart))

                    @bubblechart('StudentParam', 'timeChart')

                @endif

            </div>
        </div>
    </div>
</div>
</div>
<link href="/css/plugins/prettify.css" rel="stylesheet">
<link href="/css/plugins/style.css" rel="stylesheet">
<script src="/js/plugins/multiselect.min.js"></script>

<!--adding chart script from public/js/charts -->
<script src="/js/charts/bubbleChart.js"></script>


</script>

<script type='text/javascript'>

//Sets listeners for change in the chart select box.  
//Each chart will require different fields and this is handled by the 
//client.
$("#chartSelected").change(function () {
    //Get the current values of the check box after a change.
    var chartSelectedValue = $("#chartSelected").val();

    //Determine the type of chart based on the value obtained from the 
    //select chart field.
    determineChartType(chartSelectedValue);

});


/**
 * Purpose: This function will determine the chart type selected and load
 * the fields need for that chart.
 * 
 * @param {String} chartSelectedValue - this will be a numeric character
 * @returns {void}
 */
function determineChartType(chartSelectedValue)
{
    //Use the value obtained from the chart field to obtain the type of 
    //chart.

    $('#formDiv').show();

    switch (chartSelectedValue) {
        case '1':
            //Pie Chart

            break;
        case '2':
            //Donut Chart
            break;
        case '3':
            //Scatter Chart
            break;
        case '4':
            //Bubble Chart

            //This will show the label and select all button to load a list
            //of students to submit.
            loadBubbleChartForm();
            $('#bubbleMultiSelect').show();

            break;
        case '5':
            //Column Chart

            loadColumnChartForm();

            break;
        case '6':
            //Bar Chart
            break;
        case '7':
            //Combo Chart
            break;
        case '8':
            //Area Chart
            break;
        case '9':
            //Line Chart

            break;
        default:

    }
}


// this 
function loadColumnChartForm()
{
    hideBubbleChartSelections();
    $("#classSelectedLabel").show();
    $("#classSelected").show();
}


</script>


@endsection
