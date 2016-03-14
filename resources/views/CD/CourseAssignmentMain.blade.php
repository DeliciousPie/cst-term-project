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
                    <div id="messageDiv"></div>
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
                                            Former::select('Classes')->options($classes)->setAttribute('size', '10')
                                            ->id('courseSelection'),
                                            Former::actions()
                                            ->large_primary_submit('Generate Professors and Students')
                                            ->id('getProfessorAndStudent')
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
                                <div class="panel-body" id="professorBody">       

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
                                    <div class="col-lg-7" id="studentColOne"></div>
                                    <div class="col-lg-7" id="studentColTwo"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7" id="FinalSubmitDiv">
                            <button id="submitSectionAssignment" type="button" class="btn-large btn-primary btn" data-toggle="modal" data-target="#errorModal">Add Professors and Students to Section</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="color:white; background-color: green ">

            <div class="modal-header">
                <h3 class="modal-title">Message</h3>
            </div>
            <div class="modal-body center-block">
                <h2 id='errorModMessage'></h2>

            </div>
            <div class="modal-footer">
            </div>
            </form>
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
    $("#ProfessorDiv").hide();
    $("#StudentDiv").hide();
    $("#FinalSubmitDiv").hide();
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



//  displays professors and students after the CD has selected 
//  a course to assign students and professors to. 
$("#getProfessorAndStudent").click(function (event)
{
    // prevents the site from posting threw defalt button click 
    event.preventDefault();
    // loads the progress wheel 
    $(".loading").fadeIn("slow");

    // grabs the course ID from the select box and prep to post threw ajax 
    var courseSection = $('#courseSelection  option:selected').text();

    // if no course id i selected display warnning to CD 
    if (courseSection === '')
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
            'courseSection': courseSection
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // this is used after the course is posted and the prof and students 
        // related to the course is returned. adds all the prof and students 
        // to there div so that they can be added to the sections 
        $.post('CourseAssignmentMain/getProfessorAndStudent', course, function (data)
        {


            if (jQuery.isEmptyObject(data.professors))
            {
                $("#professorBody").html('<div class="alert alert-danger"> No Professors in the Database </div>');
            }
            else
            {
                /// creates the prof div will all profs related to the course 
                var professorSelectionDivOne = "<div class=' col-sm-6' id='DivOne'> ";
                var professorSelectionDivTwo = "<div class=' col-sm-6' id='DivTwo'> ";
                for (var count in data.professors)
                {
                    var professorSelection = "<div class='checkbox'> <label for='professorSelection" +
                            data.professors[count].userID + "'>" +
                            "<input name='professorSelection' id='professorSelection" +
                            data.professors[count].userID + "' type='checkbox' value='" +
                            data.professors[count].userID + "'> Dr. " + data.professors[count].lName +
                            "</div> </label>";
                    if (count % 2)
                    {
                        professorSelectionDivOne += professorSelection;
                    }
                    else
                    {
                        professorSelectionDivTwo += professorSelection;
                    }
                }
                $("#professorBody").html('<div class="form-group">' + professorSelectionDivOne +
                        "</div>" + professorSelectionDivTwo + "</div></div>");
            }

            if (jQuery.isEmptyObject(data.students))
            {
                $("#StudentBody").html('<div class="alert alert-danger"> there is no Students assigned '
                + 'to this course section in the Database </div>');
            }
            else
            {
                /// creates the student div will all students related to the course         
                var studentSelectionDivOne = " <div class=' col-sm-6' id='DivOne'> ";
                var studentSelectionDivTwo = " <div class=' col-sm-6'  id='DivTwo'> ";
                for (var count in data.students)
                {
                    var studentSelection = "<div class='checkbox' > <label for='studentSelection" +
                            data.students[count].userID + "'>" +
                            "<input  name='studentSelection' id='studentSelection" +
                            data.students[count].userID + "' type='checkbox' value='" +
                            data.students[count].userID + "'>" +
                            data.students[count].fName + ", " + data.students[count].lName +
                            "</div></label>";
                    if (count % 2)
                    {
                        studentSelectionDivOne += studentSelection;
                    }
                    else
                    {
                        studentSelectionDivTwo += studentSelection;
                    }
                }
                $("#StudentBody").html('<div class="form-group">' + studentSelectionDivOne +
                        "</div>" + studentSelectionDivTwo + "</div></div>");
            }

            /*
             *   this will alow the radio buttons to deselect when the CD selects 
             *   the text box to add another section type 
             */
            $('#otherSectionType').click(function ()
            {
                $('input:radio[name=Section]').each(function () {
                    $(this).prop('checked', false);
                });
            });

            /*
             *   this will alow the text box to empty when the CD selects 
             *   one of the radio buttons to add another one of the pre- 
             *   defined section types 
             */
            $('input:radio[name=Section]').click(function () {
                $('#otherSectionType').val('');
                $('#otherSectionTypeDescrip').val('');

            });


            // hids the loading wheel after all steps are finished and 
            //  shows all divs related to section assignment 
            $("#SectionDiv").show();
            $("#ProfessorDiv").show();
            $("#StudentDiv").show();
            $("#FinalSubmitDiv").show();
            $(".loading").hide();


        });
    }
});

/*
 * 
 * when the submit section assignemnt button is clicked 
 * this will take in the section selected, the students and the profs that have
 * been checked and add them to the list to match  
 */
$("#submitSectionAssignment").click(function (event)
{

    event.preventDefault();
    $(".loading").fadeIn("slow");
    // gathers the section id that was selected and the course id that is 
    // still chosen

    var courseSection = $('#courseSelection  option:selected').text();

    // gathers up all the students that the CD selected to be 
    // in the section 
    var studentList = [];
    var professorList = [];
    $(":checkbox").each(function ()
    {
        var ischecked = $(this).is(":checked");
        if (ischecked)
        {
            if ($(this).attr('name') === 'studentSelection')
            {
                studentList.push($(this).val());
            }
            if ($(this).attr('name') === 'professorSelection')
            {
                professorList.push($(this).val());
            }
        }
    });

    // used to load Modal if the CD has not selected a section or 
    // inputed a section into the "other" text area 
//    if (jQuery.isEmptyObject(courseSection))
//    {
//        $(".loading").hide();
//        $('#errorModMessage').html("There has not been a section specified.");
//        $("$errorModal").modal('show');
//    }
    // used to load Modal if the CD has not selected one or more Professors
     if (jQuery.isEmptyObject(professorList))
    {
        $(".loading").hide();
        $('#errorModMessage').html("There are no professor selected.");
        $("$errorModal").modal('show');
    }
    // used to load Modal if the CD has not selected one or more Professors
    else if (jQuery.isEmptyObject(studentList))
    {
        $(".loading").hide();
        $('#errorModMessage').html("There are no student selected.");
        $("$errorModal").modal('show');
    }
    // if the CD has selected one section, profs, and students then 
    // send ajax request to insert course section into the database 
    else
    {
        // use so that the modal will not show up if there is a 
        // valid submit 
        $(this).removeAttr('data-toggle');
        // this will post all the information when the post is sent 
        // ie. courseID, section name, student list, and prof list 
        
        var postData = {
            'courseSection': courseSection,
            'studentList': studentList,
            'professorList': professorList
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // this will send a rout message to assign the students and profs to the 
        // posted section 
        $.post('CourseAssignmentMain/assignToSection', postData, function (data)
        {
            // after the post has been executed it will chose to hid or 
            // keep the divs displayed depending on a return of error message 
            // or return of success 
            $(".loading").hide();
            $("#ProfessorDiv").hide();
            $("#StudentDiv").hide();
            $("#FinalSubmitDiv").hide();

            // if there is an error inserting into the database then 
            // display the error that gets returned from the controler 
            if (data.error)
            {
                $("#messageDiv").html('<div class="alert alert-danger">' + data.error + "</div>" +
                        '<button id="editSection" type="button" class="btn-large btn-primary" >Edit </button> ');
            }
            else
            {
                $("#messageDiv").html('<div class="alert alert-success">' + data.message + "</div>");
            }
        });
    }
});

$('#courseSelection').focus(function ()
{
    $("#ProfessorDiv").hide();
    $("#StudentDiv").hide();
    $("#FinalSubmitDiv").hide();
});


</script>
@endsection
