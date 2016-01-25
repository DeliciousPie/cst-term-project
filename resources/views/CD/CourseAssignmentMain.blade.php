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

                                    <?=
                                            Former::horizontal_open()
                                            ->openForm('forFiles', '')
                                            ->id('Import_CSVFiles')
                                            ->secure()
                                            ->rules(['name' => 'required'])
                                    ?>
                                    <?=
                                    Former::file('CourseCSV', 'Courses')->accept('.csv'),
                                    Former::file('ProfessorsCSV', 'Professors')->accept('.csv'),
                                    Former::file('StudentsCSV', 'Students')->accept('.csv'),
                                            Former::actions('')->large_primary_submit("Import Into Database")
                                            ->id('submitBtn')
                                    ?>
                                    <?= Former::close() ?>

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
                        <div class="col-md-7"id="ProfessorDiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Professors</h3>
                                </div>
                                <div class="panel-body">       
                                    <?=
                                            Former::horizontal_open()
                                            ->id('MyForm')
                                            ->secure()
                                            ->rules(['name' => 'required'])
                                            ->method('POST')
                                    ?>

                                    <?= Former::checkboxes('Professors')->checkboxes($professors)->stacked() ?>
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
                                <div class="panel-body">       

                                    <?= Former::checkboxes('Students')->checkboxes($students)->stacked() ?>
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
    var result = $('#courseSelection  option:selected').text();


    event.preventDefault();
    $("#ProfessorDiv").show();
    $("#StudentDiv").show();
    $("#FinalSubmitDiv").show();
});

                    </script>
                    @endsection
