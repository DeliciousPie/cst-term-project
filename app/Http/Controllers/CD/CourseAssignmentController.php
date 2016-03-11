<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Course;
use App\Professor;
use App\Student;
use App\Section;
use App\StudentSection;
use App\ProfessorSection;
use App\SectionType;
use App\Role;
use Illuminate\Support\Facades\Auth;

/*
 * This controler is designed to help display the 
 * course Assignment blade  to allow the CD to import 
 * corses, proffesors and students  
 */

class CourseAssignmentController extends Controller
{

    //Constructor for CourseAssignmentController
    public function _construct()
    {
        $this->middleware('cdmanager');
    }

    /*
     * LoadView queries the database for courses, students and professors.
     * It puts each group into an array.
     * Returns the three arrays back to the view
     */

    public function LoadView()
    {
        $confirmed = Auth::user()->confirmed;

        if (!$confirmed)
        {
            return redirect('CD/dashboard');
        }


        $classes = [];

        //Select all courses from Course
        $courseSections = DB::select('SELECT sectionID FROM Section');
        for ($i = 0; $i < count($courseSections); $i++)// need to get this to work dinam.. 
        {
            array_push($classes, $courseSections[$i]->sectionID);
        }
        //Return a view with a link to the view and arrays
        return view('CD/CourseAssignmentMain', compact('classes'));
    }

    /*
     * will send back two arrays of students and professors 
     * so that the CD can select which ones they want to be 
     * assined to the course sections 
     */

    public function getProfessorAndStudent()
    {
        // if the course id is set pull it from post set in to local var
        if (isset($_POST['courseSection']))
        {
            $courseSection = $_POST['courseSection'];
        }
        // database request to get professors from database 
        $professorArray = DB::select('SELECT fName, lName, userID FROM Professor ');
        //. 'where areaOfStudy = (select areaOfStudy from Course where courseID = "' . $courseID . '")');
        // database request to get students from database 
        $studentArray = DB::select('SELECT fName, lName, userID FROM Student '
                        . 'where userID in(select userID from StudentInCourseSection where sectionID="' . $courseSection . '") ');
        //. 'where areaOfStudy = (select areaOfStudy from Course where courseID = "' . $courseID . '")');
        //
        // database request to get all section types from database 
//        $sectionTypes = [];
//        $sectionTypesFromDB = DB::select('SELECT sectionID FROM SectionType');
//
//        // format into ajax return type 
//        for ($i = 0; $i < count($sectionTypesFromDB); $i++)
//        {
//            array_push($sectionTypes, $sectionTypesFromDB[$i]->sectionID);
//        }
        // return all three arrays back to the page 
        return response()->json(['professors' => $professorArray, 'students' => $studentArray]);
    }

    /*
     * used to add students and professors to the selected course and section
     * that the CD has chosen 
     */

    public function assignToSection()
    {
        // this local is used to send status of progress back to the user
        $returnMsgStrings = '';
        if (isset($_POST['courseSection']))
        {
            // sets local varables 
            $sectionID = $_POST['courseSection'];
            $studentList = $_POST['studentList'];
            $professorList = $_POST['professorList'];

                // this will get a list of all the section types in the DB
                // adds all students selected for this course/section 
                // into the student section database table 
                if (isset($_POST['studentList']))
                {
                    foreach ($studentList as $student)
                    {
                        StudentSection::create([
                            'userID' => $student,
                            'sectionID' => $sectionID
                        ]);
                    }
                }
                // adds all professor selected for this course/section 
                // into the professor section database table 
                if (isset($_POST['professorList']))
                {
                    foreach ($professorList as $professor)
                    {
                        ProfessorSection::create([
                            'userID' => $professor,
                            'sectionID' => $sectionID
                        ]);
                    }
                }
            }
            // if the Course/section combination IS in the database notify 
            // the user that they cannot enter this repeat entry into the database
        
        // if no errors happend then the success message will be sent back to CD
        if ($returnMsgStrings == '')
        {
            $returnMsgStrings = ['message' => " $sectionID has been successfully added"];
        }

        // we should return error message codes and a message with 
        // that error code 
        return response()->json($returnMsgStrings);
    }

}
