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
                        
                        <div id="courseField"></div>
                        <div id="studentField"></div>
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

<script type='text/javascript'>
    
    //Sets listeners for change in the chart select box.  
    //Each chart will require different fields and this is handled by the 
    //client.
    $("#chartSelected").change(function(){
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
        switch ( chartSelectedValue ) {
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
                addStudentSelectionField();
                addClassesSelectionField();
                produceListOfCheckboxCourses();
                //This will add all the student when the class field is select
                addStudentsToSelectionFieldOnClassSelect();
                break;
            case '5':
                //Column Chart

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
    
    /**
     * Purpose: This function will obtain a list of all the students with an
     * associated class
     * @returns {undefined}
     */
    function addStudentsToSelectionFieldOnClassSelect()
    {      

        $("#classSelected").select(function(){
            var valueOfClassSelected = $("#classSelected").val();
            $.post( "dashboard", {classSelected: valueOfClassSelected}, function(result){
               var student;
                var checkboxes = "";
                for(student in result) 
                {
                   checkboxes = checkboxes 
                           + "<div class=\"checkbox\"><input type=\"checkbox\" id=\"" 
                           + student + "\"  name=\"" + student + "\" value=\"" 
                           + student + "\">" + student + "</label></div>";
                }                
                $("#allStudents").append(checkboxes);
            });    
        });
    }
    
    /**
     *Purpose: The purpsoe of this function will show all of the courses as
     *checkboxs. 
     * 
     * @returns {void} -      
     * 
     */
    function produceListOfCheckboxCourses()
    {       
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
            $.post( "/CD/dashboard/getAllCourses", function(results){
                var checkboxes = "";
               
                for( var i = 0; i < results["courses"].length; i++ ) 
                {
                        checkboxes = checkboxes 
                           + "<div class=\"checkbox\"><label><input class=\"checkboxInputCourse\" type=\"checkbox\" id=\"" 
                           + results["courses"][i]["courseID"] + "\"  name=\"" + results["courses"][i]["courseID"] + "\" value=\"" 
                           + "false\">" + results["courses"][i]["courseID"] + "</label></div>";
                    
                }                
                $("#courseField").append(checkboxes);
            });    
        
            //
            $("#selectAllCourses").change(function(){
                if( !($("#selectAllCourses").val()))
                {
                    $(".checkboxInputCourse").prop("checked", true);
                    $("#selectAllCourses").attr("value", true);
                    
                }
                else
                {
                    $(".checkboxInputCourse").prop("checked", false);
                    $("#selectAllCourses").attr("value", false);
                    
                }
                
            });
        
    }
    
    /**
     *Purpose: This function is responsible for creating a selectionfield for
     *the bubble chart.  This list will be populated by the course(s) selected
     *in the course selection checkboxs.  All courses is an option that will
     *populate the student checkboxes.
     *
     *  
     * @returns {void} - will display the field on the form.    
     *  
     */
    function addStudentSelectionField()
    {
        $("#studentField").append(
            "<label for=\"selectAll\">Please select students for comparison:</label>" + 
            "<div class=\"checkbox\">" + 
                "<label><input type=\"checkbox\" id=\"selectAll\"" + 
            "name=\"selectAll\" value=\"selectAll\">Select All</label></div>");
    } 
    
    /**
     * Purpose: This function adds a field of checkboxes for each course.
     * The user will be able to select all the checkboxes or can select
     * individual courses.  The course picked will populate the student selection
     * field.
     * 
     * @returns {void} - display a course field and remove the previous class 
     * field and label.
     */
    function addClassesSelectionField()
    {
        $("#courseField").append(
            "<label for=\"selectAllCourses\">Please select courses for comparison:</label>" + 
            "<div class=\"checkbox\">" + 
                "<label><input type=\"checkbox\" id=\"selectAllCourses\"" + 
            "name=\"selectAll\" value=\"false\">Select All</label></div>");
    
        $("#classSelectedLabel").remove();
        $("#classSelected").remove();
            
    }  
</script>
@endsection
