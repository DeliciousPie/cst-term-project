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
    <div class="col-md-10 col-md-offset-0">

        <div class="panel panel-default">

            <div class="panel-body">
                <div id='mainBody' class="panel-body">

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
                        <div class="col-md-7" id="ImportDiv">
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
                                            Former::actions('')->large_primary_submit("Import Into Database")
                                            ->id('submitBtn')
                                    ?>


                                    <?php
                                    if (isset($_POST['courseMessage']))
                                    {
                                        echo '<p>' . $_POST['courseMessage'] . '</p>';
                                    }
                                    if (isset($_POST['professorsMessage']))
                                    {
                                        echo '<p>' . $_POST['professorsMessage'] . '</p>';
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
                                    <?php
                                    $selectHTML = '<div class="form-group"> ' .
                                            '<label for="courseSelection" class="control-label col-lg-2 col-sm-4">' .
                                            'Classes</label><div class="col-lg-10 col-sm-8">' .
                                            '<select class="form-control" size="10" id="courseSelection" name="Classes">';

                                    foreach ($classes as $key => $class)
                                    {
                                        $selectHTML .= '<option value="' . $class . '">' . $class . '</option>';
                                    }

                                    $selectHTML .= ' </select></div></div>';

                                    echo $selectHTML;
                                    if (isset($_POST['studentsMessage']))
                                    {
                                        echo '<p>' . $_POST['studentsMessage'] . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- /Course Div close -->

                        <!-- section select Boxes open  -->
                        <div class="col-md-7" id="SectionDiv" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Students To Section</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" id='alreadyAssignedDiv'>


                                    </div>

                                    <div class="col-md-10" id='newSectionDiv'>
                                        <?=
                                        Former::text('Section'),
                                        Former::file('StudentsCSV', 'Students')->accept('.csv'),
                                                Former::actions()
                                                ->large_primary_submit('assign Students to Section')
                                                ->id('getSection');
                                        ?>
                                        <?= Former::close() ?>
                                    </div>


                                </div>
                            </div>
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

// this hides loading wheel when page loads and all other divs 
// that the CD should not be seeing before generating the lists 
$(window).load(function ()
{
// when the page is first loaded hid empty div's 
    $(".loading").hide();
    $("#SectionDiv").hide();
});

// when the generate students and professors button is selected
//  this will display loading wheel 
// so that the user does not click any other objects and knows that the 
// page is working on their request 
$("#submitBtn").click(function (event)
{
    // prevent the page from posting before the loading wheel shows 
    event.preventDefault();
    $(".loading").fadeIn("slow");
    // now submit the CSV file 
    $("#Import_CSVFiles").submit();
});


$("#getSection").click(function (event)
{
    // prevent the page from posting before the loading wheel shows 
    event.preventDefault();
    $(".loading").fadeIn("slow");
    // now submit the CSV file 
    $("#Import_CSVFiles").submit();
});


$('#courseSelection').change(function ()
{
    $(".loading").fadeIn("slow");
    var courseID = $('#courseSelection  option:selected').text();
    if (courseID === '')
    {
        $("#sectionBody").html('<div class="alert alert-danger">' +
                "You Have not Selected a Course! Please select one from the \n\
                Courses above. " + "</div>");
        $("#SectionDiv").show();
        $(".loading").hide();
    }
    else // if they have selected a course run ajax call 
    {
        // prep for ajax request 
        var course = {
            'courseID': courseID
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('CSVImport/getSections', course, function (data)
        {
            var sectionSelectBox = '';

            sectionSelectBox = ' <label for="Selection" class="control-label col-lg-2 col-sm-4">already assigned Sections</label>' +
                    '<div class="col-lg-10 col-sm-8"><select class="form-control" size="6" id="Selection" name="Classes">';
            for (var count in data.coursesSection)
            {
                sectionSelectBox += "<option value=" + data.coursesSection[count] + " >" + data.coursesSection[count] + " </option>";
            }

            sectionSelectBox += "</select></div>";
            $("#SectionDiv").show();
            if ((data.coursesSection[0]) != null)
            {
                $("#alreadyAssignedDiv").html('<div class="form-group">' + sectionSelectBox + '' +
                        '<input class="btn-large btn-primary btn" id="btnNewSection" value="Create new Sections"> ' +
                        '<input class="btn-large btn-primary btn" id="btnEditSection" value="edit selected Sections"> </div></div>');
                $("#newSectionDiv").hide();
                $("#alreadyAssignedDiv").show();
            }
            else
            {
                $("#newSectionDiv").show();
                $("#alreadyAssignedDiv").hide();
            }
            $(".loading").hide();


            $("#btnNewSection").click(function (event)
            {
                event.preventDefault();
                $("#newSectionDiv").show();
                $("#alreadyAssignedDiv").hide();

            });





        });
    }


});






</script>
@endsection
