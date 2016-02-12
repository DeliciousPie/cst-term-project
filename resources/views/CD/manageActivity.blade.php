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
</style>

<div>
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

                            <select id='profSelect' multiple class="form-control" style="height:500px" onchange="loadCourses()">

                                @if ( isset($listOfProfs) )

                                @foreach($listOfProfs as $prof)
                                <option value="{!! $prof['userID'] !!}" >{!! $prof['lName'] !!}, {!! $prof['fName'] !!}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>

                        <!--Middle Spacing-->
                        <div class="col-md-1">
                        </div>

                        <!--Assignment Select-->
                        <div class="col-md-6">
                            <h2>Assigned Courses</h2>

                            <select id='courseSelect' multiple class="form-control" style="height:232px" onchange='loadActivities()'>
                            </select>

                            <!--Assignments Select Box-->
                            <h2>Activities</h2>
                            <button type="button" class="btn btn-default" style="width:31%" data-toggle="modal" data-target="#myModal">Add Activity</button>
                            <button type="button" class="btn btn-default" style="width:31%">Edit Activity</button>
                            <button type="button" class="btn btn-default" style="width:31%">Delete Activity</button>


                            <!--Assignment Select-->
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

                <div class="modal-header" style='background: #008040; color: white;'>
                    <h3 class="modal-title" style="font-weight: bold;">Add Activity</h3>
                </div>
                <div class="modal-body center-block">
                    <label for="activityName">Activity Name</label>
                    <br>
                    <h6>The name of the activity. Ex: Midterm1, Assignment2</h6>
                    <div class="input-group" style="width:100%">
                        <input id="activityName" class="form-control" name="activityName" type="text" placeholder="Activity Name" style="width:100%">
                    </div>
                    <br>
                     <label for="startDate">Start Date</label>
                    <br>
                    <h6>The day and time that the activity will be given.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="startDate" class="form-control" name="startDate" type="datetime-local" placeholder="Start Date" style="width:100%">
                    </div>
                    <br>
                    <label for="dueDate">Due Date</label>
                    <br>
                    <h6>The day and time that the activity will be due.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="dueDate" class="form-control" name="dueDate" type="datetime-local" placeholder="Due Date" style="width:100%">
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
                    <h6>Stress Estimate: 1 is the lowest, 10 is the highest.</h6>
                    <div class="input-group" style="width:100%">
                        <input id="stresstimate" class="form-control" name="stresstimate" type="number" min="1" max="10" style="width:100%"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="submit" value="Submit" formethod="POST" class="btn btn-info pull-right" style='background: #008040;'>
                </div>
            </form>
        </div>
    </div>
</div>

<!--This script is for loading each course the professor is teaching-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" >

    $(document).ready(function () {


        //function loadCourses()
        window.loadCourses = function ()
        {
            $('#activitySelect').html('');

            var profID = $('#profSelect').val();
            var prof = {
                'profID': profID
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});

            $.post('/CD/manageActivity/loadSelectedProfsCourses', prof, function (data)
            {
                var string = "";

                // check if the professor has courses, if not then display so.
                if (data.courses.length === 0)
                {
                    string += "<option>Professor Has No Courses</option>";
                }

                for (var count in data.courses)
                {
                    string += "<option value='" + data.courses[count].courseID
                            + "'>" + data.courses[count].courseID + " - "
                            + data.courses[count].courseName + "</option>";
                }

                $('#courseSelect').html(string);
            });
        }
    });
</script>

<script type="text/javascript">


    google.charts.load('current', {'packages': ['table']});

    function drawTable(ajaxData) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Activity Name');
        data.addColumn('string', 'Start Date');
        data.addColumn('string', 'Due Date');
        data.addColumn('string', 'Estimated Time');
        data.addColumn('number', 'Stresstimate')

            if(ajaxData.activities.length > 0)
            {
                for (var aCount in ajaxData)
                {
                    for (var count in ajaxData.activities)
                    {   
                        data.addRow([ajaxData.activities[count].activityType,
                            ajaxData.activities[count].assignDate,
                            ajaxData.activities[count].dueDate, 
                            ajaxData.activities[count].estTime,
                            ajaxData.activities[count].stresstimate
                            ]);
                    }
                }
            }
            else
            {
              data.addRows([
                    ['There are no assignments for the selected course', null, null, null, null],
              ]);
            }

        var chart = new google.visualization.Table(document.getElementById('activitySelect'));

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

        var options = {'showRowNumber': false, 'width': '100%', 'height': '100%', 'cssClassNames': cssClassNames};


        chart.draw(data, options);

        function selectHandler() {
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                var name = data.getValue(selectedItem.row, 0);
                var salary = data.getValue(selectedItem.row, 1);
                alert('The user selected ' + name + ' and makes $' + salary);
            }
        }


        google.visualization.events.addListener(chart, 'select', selectHandler);
        //chart.draw(data, options, {width: '100%'});
    }

</script>

<!--This script is for adding activities based on the course selected-->
<script type="text/javascript" >

    $(document).ready(function () {

        window.loadActivities = function ()
        {
            var courseID = $('#courseSelect').val();
            var course = {
                'courseID': courseID
            };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});

            $.post('/CD/manageActivity/loadSelectedCoursesActivities', course, function (data)
            {                    
                  drawTable(data);
            });
        }
    });
</script>
@endsection