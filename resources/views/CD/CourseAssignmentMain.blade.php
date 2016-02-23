@extends('layouts.app')

@section('title')
<title>Curricular Developer Course Assignment Page</title>
@stop


@section('navBarHeader')
<a class="navbar-brand" href="{{ url('/') }}">Curricular Developer Course Assignment Page </a>
@stop

@section('bodyHeader')
<h1 >
    Course Assignment 
</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div class="panel panel-default">

            <div class="panel-body">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i>Course Assignment</h3>
                </div>
                <div class="panel-body">

                    <style> .loading {
                            position: fixed;
                            left: 0px;
                            top: 0px;
                            width: 100%;
                            height: 100%;
                            z-index: 9999;
                            opacity:0.8;
                            background: url('http://phpserver/images/loading.gif') 50% 30% no-repeat rgb(249,249,249);
                        }</style>

                    <!--this div is for the progress wheel-->
                    <div class="loading"></div>

                    <!-- Course Div open -->
                    <div class="row">
                        <div class="col-md-7" id="CourseDiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> CSV files</h3>
                                </div>
                                <div class="panel-body">
<form enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="Import_CSVFiles" method="POST">     
    <div class="form-group">
        <label for="CourseCSV" class="control-label col-lg-2 col-sm-4">Courses</label>
        <div class="col-lg-1 col-sm-1"></div>
        <div class="col-lg-9 col-sm-7">
            <input accept=".csv" id="CourseCSV" type="file" name="CourseCSV"></div>
    </div>
    <div class="form-group">
        <label for="ProfessorsCSV" class="control-label col-lg-2 col-sm-4">Professors</label>
         <div class="col-lg-1 col-sm-1"></div>
        <div class="col-lg-9 col-sm-7">
            <input accept=".csv" id="ProfessorsCSV" type="file" name="ProfessorsCSV">
        </div>
    </div>
    <div class="form-group">
        <label for="StudentsCSV" class="control-label col-lg-2 col-sm-4">Students</label>
        <div class="col-lg-1 col-sm-1"></div>
        <div class="col-lg-9 col-sm-7">
            <input accept=".csv" id="StudentsCSV" type="file" name="StudentsCSV"></div>
    </div>
    <div class="form-group" id="submitBtn">
        <div class="col-lg-offset-2 col-sm-offset-4 col-lg-10 col-sm-8"> 
            <input class="btn-large btn-primary btn" type="submit" value="Import Into Database">
        </div>
    </div>                                   
    <input class="form-control" type="hidden" name="_token" value="5Yo1HlptMI5Eqcmzjfrq3nbTxG6gFHbPbd7UA35Y">
</form>    
                                   
                                    
                                    <?php
                                    if (isset($_POST['courseMessage']))
                                    {
                                        echo '<p>' . $_POST['courseMessage'] . '</p>';
                                    }
                                    if (isset($_POST['professorsMessage']))
                                    {
                                        echo '<p>' . $_POST['professorsMessage'] . '</p>';
                                    }
                                    if (isset($_POST['studentsMessage']))
                                    {
                                        echo '<p>' . $_POST['studentsMessage'] . '</p>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <!-- Course Div open -->
                        <div class="col-md-7" id="CourseDiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Course</h3>
                                </div>
                                <div class="panel-body">
                                    <?=
                                            Former::horizontal_open()
                                            ->id('CourseSelect')
                                            ->secure()
                                            ->rules(['name' => 'required'])
                                            ->method('POST')
                                    ?>

                                    <?=
                                            Former::select('school')->options($classes)->setAttribute('size', '10')
                                            ->id('courseSelection'),
                                            Former::actions()
                                            ->large_primary_submit('Generate Professors and students')
                                            ->id('getProfAndStu')
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- /Course Div close -->

                        <!-- Professor select Boxes open  -->
                        <div class="col-md-7" id="ProfessorDiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Professors</h3>
                                </div>
                                <div class="panel-body" id="profBody">       
                                    <?=
                                            Former::horizontal_open()
                                            ->id('profList')
                                            ->secure()
                                            ->rules(['name' => 'required'])
                                            ->method('POST')
                                    ?>

                                    <!--                                   // Former::checkboxes('Professors')->checkboxes($professors)->stacked() -->
                                </div> <!-- body close-->    
                            </div>
                        </div>
                        <!-- /Professor select Boxes close  -->


                        <!-- Student select Boxes open  -->
                        <div class="col-lg-7" id="StudentDiv">
                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Students</h3>
                                </div>
                                <div class="panel-body" id="StudentBody" >       


                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7" id="FinalSubmitDiv">
                            <?=
                                    Former::actions()
                                    ->large_primary_submit('Finished ')
                                    ->large_inverse_reset('Reset')
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- /Student select Boxes close -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

// this hides loading wheel when page loads 
$(window).load(function () {
    $(".loading").hide();
    $("#ProfessorDiv").hide();
    $("#StudentDiv").hide();
    $("#FinalSubmitDiv").hide();
});

// when the button is selected this will display loading wheel 
// so that the user does not click any other objects and knows that the 
// page is working on there request 

$("#submitBtn").click(function (event)
{
    event.preventDefault();
    $(".loading").fadeIn("slow");

    $("#Import_CSVFiles").submit();
});

// displays professors and students

$("#getProfAndStu").click(function (event)
{
    $(".loading").fadeIn("slow");
    var courseID = $('#courseSelection  option:selected').text();

    var course = {
        'courseID': courseID};
    event.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('CourseAssignmentMain/getProfAndStu', course, function (data)
    {
        $("#profBody").html("<form action='professorCheckGroup'>");
        for (var count in data.professors)
        {
            $("#profBody").append("<input type='checkbox' value='" +
                    data.professors[count].userID + "' >" +
                    data.professors[count].fName + "<br>");
        }
        $("#profBody").append("</form>");




        $("#StudentBody").html("<form action='studentCheckGroup'>");
        for (var count in data.students)
        {
            $("#StudentBody").append("<input type='checkbox' value='" +
                    data.students[count].userID + "' >" +
                    data.students[count].fName + "<br>");
        }

        $(".loading").hide();

    });


    $("#ProfessorDiv").show();
    $("#StudentDiv").show();
    $("#FinalSubmitDiv").show();
});

</script>
@endsection
