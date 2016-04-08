/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$("#submitBtn").click(function (event)
{
    // prevent the page from posting before the loading wheel shows 
    event.preventDefault();

    $("#studentundo_redo_to").find('optgroup').each(function ()
    {
        $(this).find('option').each(function ()
        {
            $(this).prop('selected', true);
        });
    });
    $("#customChartForm").submit();
});

function loadBubbleChartForm()
{
    addClassesSelectionField();
    produceListOfCourseCrossSelect();
    addStudentSelectionField();
    showStudentCrossSelect();

}

function hideBubbleChartSelections()
{
    $('#bubbleMultiSelect').hide();

    //this will show the bubble radius.
    $('#bubbleRadius').hide();
    //This will hide the select box for the bubble radius
    $('#comparison3').hide();
}


/**
 * Purpose: This functions job is to show the the student cross selection 
 * box.
 * 
 * @returns {undefined}
 */
function showStudentCrossSelect()
{
    $('#studentField').show();

    //Loop through the remove Attr hidden AKA show the course field
    $('#courseField').show();

    //this will show the bubble radius.
    $('#bubbleRadius').show();
    $('#comparison3').show();
}

/**
 * Purpose: This function will obtain a list of all the students with an
 * associated class
 * 
 * @param {array} a course that will be used to query all the students.
 * @returns {undefined}
 */
function addStudentsToSelectionFieldOnClassSelect(course)
{
    //Set up/prime an ajax call.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

    //this will perform a ajax post request.
    $.post("/CD/dashboard/getAllStudentByCourse", {class: course},
    /**
     * Purpose: The purpose of this callback function will create 
     * options for the select boxes.
     * 
     * @param {type} results - An array of students that are in the 
     * course.
     * @returns {undefined}
     */
    function (results) {

        //Will hold html code for options in select boxes.
        var options = "";

        //Create a course title box.  The class will be used to make 
        //sure that the course titles can't be moved.
        options = "<optgroup label=\"" + course +
                "\" class=\"" + course + "\" >";

        //Loop through each result (all the students)
        for (var i = 0; i < results["courseByStudent"].length; i++)
        {
            //Will create options boxes in the format 
            //userID lastName, firstName
            options = options
                    + "<option class=\"" + course + "\""
                    + " value=\""
                    + course + ", " + results["courseByStudent"][i]["userID"]
                    + "\">"
                    + results["courseByStudent"][i]["userID"] + " "
                    + results["courseByStudent"][i]["lName"] + ", "
                    + results["courseByStudent"][i]["fName"] + "</option>";

        }
        options = options+ "</optgroup>"

        //Get a hold on the left hand student selection box.
        var studentCrossSection = $('#studentField').find('#studentundo_redo');

        //Add the options to the box.
        studentCrossSection.append(options);


    });

    //Get handle on the student select box on left.
    var studentCrossSection = $('#studentField').find('#studentundo_redo');

    //Add the multiselect ability to the boxes.
    studentCrossSection.multiselect({selectableOptgroup: true});

    $('#studentundo_redo_rightAll').click(function () {

    });

    $('#studentundo_redo_rightSelected').on("click", function () {
        var studentCrossSectionTo = $('#studentField').find('#studentundo_redo_to');
        studentCrossSectionTo.multiselect({selectableOptgroup: true});
    });
    
    
    
    
    
}

/**
 *Purpose: The purpsoe of this function will show all of the courses as
 *checkboxes. 
 * 
 * @returns {void}      
 * 
 */
function produceListOfCourseCrossSelect()
{
    //Set up the ajax call
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

    //Make a post request that will return all of the courses in the DB
    $.post("/CD/dashboard/getAllCourses", function (results) {

        //hold all the options for the select boxes.
        var options = "";

        //loop through all courses
        for (var i = 0; i < results["courses"].length; i++)
        {
            //Create an options tag that will represent a course.
            options = options
                    + "<option"
                    + " value=\"" + results["courses"][i]["courseID"]
                    + "\"> "
                    + results["courses"][i]["courseID"] + "</option>";
        }



        //get a handle on the course select box on the left handside.
        var studentCrossSection = $('#courseField').find('#undo_redo');

        //Add the options to the left hand side select box.
        studentCrossSection.append(options);
    });

    //get a handle on the course select box on the left handside.
    var studentCrossSection = $('#courseField').find('#undo_redo');

    //Add multiselect functionality (Move objects).
    studentCrossSection.multiselect({selectableOptgroup: true});


    $('#undo_redo_rightAll').click(function () {

        //Get a handle of the courses that have been moved.
        var courses = $('#undo_redo_to').find('option');
        //For each course add the students to the list in the student
        //select box.
        courses.each(function () {

            //clearStudent
            $('#studentField').find('#studentundo_redo').html("");
            $('#studentField').find('#studentundo_redo_to').html("");
            //The value of the options selected.
            addStudentsToSelectionFieldOnClassSelect($(this).val());
        });
    });

    //this will add students to the sutdent select boxes based on the 
    //courses moved to the right hand side.
    $('#undo_redo_rightSelected').on("click", function () {

        //Get a handle of the courses that have been moved.
        var courses = $('#undo_redo_to').find('option');
        //For each course add the students to the list in the student
        //select box.
        courses.each(function () {

            //clearStudent
            $('#studentField').find('#studentundo_redo').html("");
            $('#studentField').find('#studentundo_redo_to').html("");
            //The value of the options selected.
            addStudentsToSelectionFieldOnClassSelect($(this).val());
        });
    });

    $('#undo_redo_leftSelected').click(function () {
         //Get a handle of the courses that have been moved.
        var courses = $('#undo_redo_to').find('option');
        //For each course add the students to the list in the student
        //select box.
        courses.each(function () {

            //clearStudent
            $('#studentField').find('#studentundo_redo').html("");
            $('#studentField').find('#studentundo_redo_to').html("");
            //The value of the options selected.
            addStudentsToSelectionFieldOnClassSelect($(this).val());
        });



    });

    $('#undo_redo_leftAll').click(function () 
    {
        $('#studentundo_redo').children().remove();
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
    $("#studentFieldLabel").append(
            "<label for=\"selectAll\">Please select students for comparison:</label>");
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
    $("#courseFieldLabel").append(
            "<label for=\"selectAllCourses\">Please select courses for comparison:</label>");

    $("#classSelectedLabel").hide();
    $("#classSelected").hide();

}