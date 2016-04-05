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
<style type='text/css'>
    .large-width{
        width: 100%;
    }

    .bold-font{
        font-weight:bold;
    }

    .white-background{
        background-color: white;
    }

    .purple-select{
        background-color: #cdcdcd;
    }
    .loading {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        opacity:0.8;
        background: url('http://phpserver/images/loading.gif') 50% 30% no-repeat rgb(249,249,249);
    }

</style>

<div>
    <!--this div is for the progress wheel-->
    <div class="loading"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="row">
                    <form method="post" action=''>
                        <input type="hidden" name='_token' value="{!! csrf_token() !!}">
                        <meta name="csrf-token" content="{{ csrf_token() }}">

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

                            <select id='profSelect' name='profSelect' multiple class="form-control" style="height:500px" onchange="loadCourses()">

                                <!--load all of the professors into the select box-->
                                @if ( isset($listOfProfs) )

                                @foreach($listOfProfs as $prof)
                                <option value="{!! $prof['userID'] !!}" >{!! $prof['lName'] !!}, {!! $prof['fName'] !!}</option>
                                @endforeach
                                @else
                                <option>There are no professors. Try adding some using the Course Assignment page.</option>
                                @endif

                            </select>
                        </div>

                        <!--Middle Spacing-->
                        <div class="col-md-1">
                        </div>

                        <!--Assignment Select-->
                        <div class="col-md-6">
                            <h2>Assigned Courses</h2>

                            <select id='courseSelect' name='courseSelect' multiple class="form-control" style="height:232px" onchange='loadActivities()'>
                            </select>

                            <!--Assignments Select Box-->
                            <h2>Activities</h2>
                            <!--Should enable when selecting a course-->
                            <button type="button" id="addActivityButton" class="btn btn-default" style="width:31%" data-toggle="modal" data-target="#myModal" onclick="javascript:clearFields();" disabled >Add Activity</button>

                            <!--Should enable when an activity is selected-->
                            <button type="button" id="editActivityButton" class="btn btn-default" style="width:31%" disabled >Edit Activity</button>

                            <!--Should enable when an activity is selected-->
                            <button type="button" id="deleteActivityButton" class="btn btn-default" style="width:31%" disabled >Delete Activity</button>

                            <!--Assignment Select Google Chart Table-->
                            <br><br>
                            <div id="activitySelect" style="width:95%; max-height:150px"></div>
                        </div>
                        <!--Right Spacing-->
                        <div class="col-md-1">
                        </div>
                </div>
                </form>
                <div class="panel-body">
                </div>
            </div>

            <p>May take awhile to load professors and courses.</p>
        </div>
    </div>
</div>

<!-- The modal for adding an activity -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="color:black">
            <form id="addActivityForm" method="POST">
                <input type="hidden" name='_token' value="{!! csrf_token() !!}">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="modal-header" style='background: #008040; color: white;'>
                    <h3 class="modal-title" style="font-weight: bold;">Add Activity</h3>
                </div>
                <div class="modal-body center-block">
                    <label for="activityName">Activity Name</label>
                    <br>
                    <h6>The name of the activity. Ex: Midterm1, Assignment2</h6>
                    <div class="input-group" style="width:100%">
                        <input id="activityName" class="form-control" name="activityName" type="text" placeholder="Assignment 1" onchange="javascript:validateActivitySubmit();" style="width:100%">
                    </div>
                    <br>
                    <!--Activity Error Message Box-->
                    <div id="modalAlertBoxActivity" class="alert alert-danger" style="display: none">
                    </div>
                    <label for="startDate">Start Date</label>
                    <br>
                    <h6>The day and time that the activity will be given.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="startDate" class="form-control" name="startDate" type="date" placeholder="Start Date" onchange="javascript:validateActivitySubmit();" style="width:100%">
                    </div>
                    <br>
                    <label for="dueDate">Due Date</label>
                    <br>
                    <h6>The day and time that the activity will be due.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="dueDate" class="form-control" name="dueDate" type="date" placeholder="Due Date" onchange="javascript:validateActivitySubmit();" style="width:100%">
                    </div>
                    <br>
                    <!--Due Date Error Message Box-->
                    <div id="modalAlertBoxDue" class="alert alert-danger" style="display: none">
                    </div>
                    <label for="workload">Workload(hr)</label>
                    <br>
                    <h6>The estimated amount of time needed to finish the activity, in hours.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="workload" class="form-control" name="workload" type="number" min="1" max="800" onchange="javascript:validateActivitySubmit();" style="width:100%">
                    </div>
                    <br>
                    <!--Workload Error Message Box-->
                    <div id="modalAlertBoxWorkload" class="alert alert-danger" style="display: none">
                    </div>

                    <label for="stresstimate">Stresstimate</label>
                    <br>
                    <h6>Stress Estimate: 1 is the lowest, 10 is the highest.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="stresstimate" class="form-control" name="stresstimate" type="number" min="1" max="10" onchange="javascript:validateActivitySubmit();" style="width:100%"> 
                    </div>

                    <br>
                    <!--Stesstimate Error Message Box-->
                    <div id="modalAlertBoxStresstimate" class="alert alert-danger" style="display: none">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:clearFields();">Close</button>

                        <!--Add Activity Modal Button-->
                        <button type="button" id="modalSubmit" name="modalSubmit" class="btn btn-info pull-right" onclick="javascript:validateActivitySubmit();" >Submit</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!--This script is for loading each course the professor is teaching-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" >

$(document).ready(function ()
{
    $(".loading").hide();
    // Load the courses for the selected professor, into the select box
    window.loadCourses = function ()
    {
        $(".loading").fadeIn("slow");
        // Reset the activities and buttons when a professor is clicked
            $('#activitySelect').html('');
            $('#courseSelect').html('');
            $('#addActivityButton').prop('disabled', true);

            //These buttons should be enabled when an activity is selected not when a course is selected
            //$('#editActivityButton').prop('disabled', true);
            //$('#deleteActivityButton').prop('disabled', true);

            // Get the professors id
            var profID = $('#profSelect').val();

            // set the profID
            var prof = {
                'profID': profID,
            };

            // Specify the token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});

            // Ajax call to the Activity Manager Controller to load the professor's courses
            $.post('/CD/manageActivity/loadSelectedProfsCourses', prof, function (data)
            {
                var string = "";

                // check if the professor has courses, if not then display so.
                if (data.courses.length === 0)
                {
                    string += "<option>Professor Has No Courses</option>";
                }

                // Loop through each course and append it to the select box
                for (var count in data.courses)
                {
                    string += "<option value='" + data.courses[count].sectionID
                            + "'>" + data.courses[count].sectionID + " - "
                            + data.courses[count].courseName + "</option>";
                }

                // Add the courses to the select box
                $('#courseSelect').html(string);
                $(".loading").hide();
            });
        }
    });
</script>

<script type="text/javascript">

    // Load the table char
    google.charts.load('current', {'packages': ['table']});

    // Used to create the table, and pass in the Activity data
    function drawTable(ajaxData)
    {
        // enable the activity button
        $('#addActivityButton').prop('disabled', false);

        //            These buttons should be enabled when an activity is selected not when a course is selected
        //$('#editActivityButton').prop('disabled', false);
        //$('#deleteActivityButton').prop('disabled', false);

        // Actually make the table appear
        var data = new google.visualization.DataTable();

        // Add the columns for each activity
        data.addColumn('string', 'Activity Name');
        data.addColumn('string', 'Start Date');
        data.addColumn('string', 'Due Date');
        data.addColumn('string', 'Estimated Time');
        data.addColumn('number', 'Stresstimate');
        data.addColumn('number', 'ActivityID');

        // If there are more than 0 activities
        if (ajaxData.activities.length > 0)
        {
            // Loop through each activity
            for (var aCount in ajaxData)
            {
                for (var count in ajaxData.activities)
                {
                    // Add each activity to the table
                    data.addRow([ajaxData.activities[count].activityType,
                        ajaxData.activities[count].assignDate.substring(5,7) + "-" +
                        ajaxData.activities[count].assignDate.substring(8,10) + "-" +
                        ajaxData.activities[count].assignDate.substring(0,4),
                        ajaxData.activities[count].dueDate.substring(5,7) + "-" +
                        ajaxData.activities[count].dueDate.substring(8,10) + "-" +
                        ajaxData.activities[count].dueDate.substring(0,4),
                        ajaxData.activities[count].estTime,
                        ajaxData.activities[count].stresstimate,
                        ajaxData.activities[count].activityID
                    ]);
                }
            }
        }
        else
        {
            // If there were no activities
            data.addRows([
                ['There are no activities for the selected course', null, null, null, null],
            ]);
        }

        var formatter = new google.visualization.DateFormat({pattern: "MM dd, ''yyyy"});
        formatter.format(data, 2);
        formatter.format(data, 3);

        var view = new google.visualization.DataView(data);
        view.setColumns([0,1,2,3,4]);

        var chart = new google.visualization.Table(document.getElementById('activitySelect'));

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            console.log(selectedItem);
            if (selectedItem) 
            {
                var topping = data.getValue(selectedItem.row, 5);
                alert('ID:' + topping);
                
            }
        }
            

        // chart styles
        var cssClassNames = {
            'headerRow': 'bold-font',
            'tableRow': '',
            'oddTableRow': 'white-background',
            'selectedTableRow': '',
            'hoverTableRow': 'purple-select',
            'headerCell': '',
            'tableCell': '',
            'rowNumberCell': '',
        };

        // Properties of the table
        var options = {'showRowNumber': false, 'width': '100%', 'height': '150px', 'cssClassNames': cssClassNames};

        //Add the event handler
        google.visualization.events.addListener(chart, 'select', selectHandler); 


        
        // draw the table using the data and options
        chart.draw(view, options);
    }

</script>

<!--This script is for adding activities based on the course selected-->
<script type="text/javascript" >

    $(document).ready(function ()
    {
        // Load the activities for the selected course
        window.loadActivities = function ()
        {
            $(".loading").fadeIn("slow");
            // Get the courseID
            var courseID = $('#courseSelect').val();

            var course = {
                'courseID': courseID
            };

            // Specify the token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});

            // Ajax call to the Activity Manager Controller to load activties for the selected course
            $.post('/CD/manageActivity/loadSelectedCoursesActivities', course, function (data)
            {
                // After the loading is done, draw the table
                drawTable(data);
                $(".loading").hide();
                $('#myModal').hide();
                $('.modal-backdrop').hide();
                clearFields();
            });
        }
    });
</script>

<!--Check if the activity to be added is valid-->
<script type="text/javascript" >

    $(document).ready(function ()
    {
        //Variables that determine if the submit button is enabled or not
        var activityNameValid = false;
        var datesValid = false;
        var workloadValid = false;
        var stressValid = false;
        
        // Check if the activity to be added is valid
        window.validateActivitySubmit = function ()
        {
            // Check that all the fields are valid then enable or disable the submit button
            if (activityNameValid === true && datesValid === true && workloadValid === true && stressValid === true)
            {
                $(".loading").show();
                submitActivity();
            }
            else 
            {
                if(activityNameValid === false)
                {
                    validateActivityName();
                }
                if(datesValid === false)
                {
                    validateActivityDate();
                }
                if(workloadValid === false)
                {
                    validateActivityWorkload();
                }
                if(stressValid === false)
                {
                    validateActivityStresstimate();    
                }
            }
        }
        
        window.validateActivityName = function()
        {
            activityNameValid = false;
            
            var activityName = $('#activityName').val();
            // Check that the activity length is valid
            if (activityName.length > 0 && activityName.length < 125 && activityName !== null && activityName !== "")
            {
                activityNameValid = true;
                $("#modalAlertBoxActivity").hide();
            }
            else
            {
                $("#modalAlertBoxActivity").html("<strong>Activity must be between 1 and 125 characters.</strong><br>");
                $("#modalAlertBoxActivity").show();
            }
        }
        
        window.validateActivityDate = function()
        {
            datesValid = false;
            
            var startDateString = $('#startDate').val();
            var dueDateString = $('#dueDate').val();
            
            var startDate = new Date(startDateString);
            var dueDate = new Date(dueDateString);
            
            // Check that the dates are valid going from year, month, to day of month
            if (startDate <= dueDate)
            {
                datesValid = true;
                $("#modalAlertBoxDue").hide();
            }

            // If the dates are invalid, alert the user
            if (datesValid === false)
            {
                $("#modalAlertBoxDue").html("<strong>Due date must be after start date.</strong><br>");
                $("#modalAlertBoxDue").show();
            }
        }
        
        window.validateActivityWorkload = function()
        {
            workloadValid = false;
            
            var workload = $('#workload').val();
             
             // Check that the workload is valid
            if (workload > 0 && workload <= 800)
            {
                workloadValid = true;
                $("#modalAlertBoxWorkload").hide();
            }
            else
            {
                $("#modalAlertBoxWorkload").html("<strong>Workload must be between 1 and 800</strong><br>");
                $("#modalAlertBoxWorkload").show();
            }
        }
        
        window.validateActivityStresstimate = function()
        {
            stressValid = false;
            
            var stresstimate = $('#stresstimate').val();
            
            // Check if the stresstimate is valid
            if (stresstimate >= 1 && stresstimate <= 10)
            {
                stressValid = true;
                $("#modalAlertBoxStresstimate").hide();
            }
            else
            {
                $("#modalAlertBoxStresstimate").html("<strong>Stresstimate must be between 1 and 10</strong><br>");
                $("#modalAlertBoxStresstimate").show();
            }
        }
        
        window.clearFields = function ()
        {
            $('#activityName').val("");
            $('#startDate').val("");
            $('#dueDate').val("");
            $('#workload').val("");
            $('#stresstimate').val("");
            
            $('#modalAlertBoxActivity').hide();
            $('#modalAlertBoxDue').hide();
            $('#modalAlertBoxWorkload').hide();
            $('#modalAlertBoxStresstimate').hide();

            stressValid = false;
            activityNameValid = false;
            datesValid = false;
            workloadValid = false;

        }
        
    });

</script>

<!--Add Activity Modal Endpoint-->
<script type="text/javascript" >

    $(document).ready(function () {

        window.submitActivity = function ()
        {
            // Get all of the values for the Activity to add
            var activityName = $('#activityName').val();
            var startDate = $('#startDate').val();
            var dueDate = $('#dueDate').val();
            var workload = $('#workload').val();
            var stresstimate = $('#stresstimate').val();
            var profID = $('#profSelect option:selected').val();
            var courseID = $('#courseSelect option:selected').val();

            var activity = {
                'activityName': activityName,
                'startDate': startDate,
                'dueDate': dueDate,
                'workload': workload,
                'stresstimate': stresstimate,
                'profID': profID,
                'courseID': courseID
            };

            // Specify the token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});

            // Ajax call to the Activity Manager Controller to insert the activity into the database
            $.post('/CD/manageActivity/addActivity', activity, function(data)
            {
                // Once we insert the new Activity, reload the Activity table
                
                loadActivities();
            });
        }
    });
</script>

@endsection