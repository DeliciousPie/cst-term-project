<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;

/**
 * Purpose: Control the AJAX loading of the professors, courses/sections, and activities.
 *          And the adding, editing, and deleting of activities.
 * 
 * @author  Anthony Fetsch CST223 & Kendal Keller CST228 
 */
class ActivityManagerController extends Controller
{

    /**
     * Purpose: Add an activity into the database, with the values that have been
     *          specified from the Activity Manager page.
     * @return null
     * @author  Anthony Fetsch CST223 & Kendal Keller CST228 

     */
    public function addActivity()
    {
        //Get rid of the html special characters to prevent SQL injections
        $activityName = htmlspecialchars($_POST['activityName']);
        $startDate = htmlspecialchars ($_POST['startDate']);
        $dueDate = htmlspecialchars ($_POST['dueDate']);
        $workload = htmlspecialchars ($_POST['workload']);
        $stresstimate = htmlspecialchars ($_POST['stresstimate']);
        $prof = htmlspecialchars ($_POST['profID']);
        $course = htmlspecialchars ($_POST['courseID']);
        if(isset($_POST['activityID']))
        {
            $activityID = htmlspecialchars ($_POST['activityID']);
        }

        
        // Check that all the fields are set
        if (isset($activityName) && isset($startDate) && isset($dueDate) 
                && isset($workload) && isset($stresstimate) && isset($prof) 
                && isset($course))
        {
            // Check if all are empty
            if (!empty($activityName) && !empty($startDate) && !empty($dueDate) 
                    && !empty($workload) && !empty($stresstimate) 
                    && !empty($prof) && !empty($course))
            {
                // Check if activity name is valid
                if (strlen($activityName) > 0 && strlen($activityName) < 125)
                {
                    // Check that startDate and dueDate are valid
                    $startDateObj = new \DateTime($startDate);
                    $dueDateObj = new \DateTime($dueDate);
                    $minDateObj = new \DateTime('0000-00-00');

                    $interval = $startDateObj->diff($dueDateObj);
                    $dateDiff = $interval->format('%R%a');
                    $minInterval = $startDateObj->diff($minDateObj);
                    $minDiff = $minInterval->format('%R%a');
                    
                    // dueDate is greater than startDate
                    if ($dateDiff >= 0 && $minDiff < 0)
                    {
                        // Check that workload is valid
                        if ($workload > 0 && $workload <= 800)
                        {
                            // Check that stresstimate is valid
                            if ($stresstimate >= 1 && $stresstimate <= 10)
                            {
                                if(isset($activityID) && !empty($activityID))
                                {
                                    //This is setting it to the first prof's section only.
                                    $results = DB::table('ProfessorSection')
                                        ->where('userID', $prof)
                                        ->where('sectionID', $course);

                                    // Check that the profID and sectionID exist in the database
                                    if (!empty($results))
                                    {
                                        // If everything is valid insert into the database
                                        $id = DB::table('Activity')->insertGetId(
                                                ['activityID' => $activityID,
                                                    'sectionID' => $course,
                                                    'activityType' => $activityName,
                                                    'assignDate' => $startDate,
                                                    'dueDate' => $dueDate,
                                                    'estTime' => $workload,
                                                    'stresstimate' => $stresstimate]
                                        );

                                        if ( $id != null )
                                        {
                                            $result = true;
                                        }
                                    }
                                }
                                else
                                {
                                    //This is setting it to the first prof's section only.
                                    $results = DB::table('ProfessorSection')
                                        ->where('userID', $prof)
                                        ->where('sectionID', $course);

                                    // Check that the profID and sectionID exist in the database
                                    if (!empty($results))
                                    {
                                        // If everything is valid insert into the database
                                        $id = DB::table('Activity')->insertGetId(
                                                ['sectionID' => $course,
                                                    'activityType' => $activityName,
                                                    'assignDate' => $startDate,
                                                    'dueDate' => $dueDate,
                                                    'estTime' => $workload,
                                                    'stresstimate' => $stresstimate]
                                        );

                                        if ( $id != null )
                                        {
                                            $result = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return null;
    }
    
    /**
     * Purpose: Edit an activity from the database, with the values that have been
     *          specified from the Activity Manager page.
     * @return null
     * @author  Anthony Fetsch CST223 & Kendal Keller CST228 

     */
    public function editActivity()
    {
         //Get rid of the html special characters to prevent SQL injections
        $activityName = htmlspecialchars($_POST['activityName']);
        $startDate = htmlspecialchars ($_POST['startDate']);
        $dueDate = htmlspecialchars ($_POST['dueDate']);
        $workload = htmlspecialchars ($_POST['workload']);
        $stresstimate = htmlspecialchars ($_POST['stresstimate']);
        if(isset($_POST['activityID']))
        {
            $activityID = htmlspecialchars ($_POST['activityID']);
        }
        
        // Check that all the fields are set
        if (isset($activityName) && isset($startDate) && isset($dueDate) 
                && isset($workload) && isset($stresstimate) && isset($activityID))
        {
            // Check if all are empty
            if (!empty($activityName) && !empty($startDate) && !empty($dueDate) 
                    && !empty($workload) && !empty($stresstimate) 
                    && !empty($activityID))
            {
                // Check if activity name is valid
                if (strlen($activityName) > 0 && strlen($activityName) < 125)
                {
                    // Check that startDate and dueDate are valid
                    $startDateObj = new \DateTime($startDate);
                    $dueDateObj = new \DateTime($dueDate);
                    $minDateObj = new \DateTime('0000-00-00');
                    $maxDateObj = new \DateTime('2999-12-31');
                    
                    $interval = $startDateObj->diff($dueDateObj);
                    $dateDiff = $interval->format('%R%a');
                    $minInterval = $startDateObj->diff($minDateObj);
                    $minDiff = $minInterval->format('%R%a');
                    $maxInterval = $startDateObj->diff($maxDateObj);
                    $maxDiff = $minInterval->format('%R%a');
                    
                    // dueDate is greater than startDate
                    if ($dateDiff >= 0 && $minDiff < 0)
                    {
                        // Check that workload is valid
                        if ($workload > 0 && $workload <= 800)
                        {
                            // Check that stresstimate is valid
                            if ($stresstimate >= 1 && $stresstimate <= 10)
                            {
                                if(isset($activityID) && !empty($activityID))
                                {
                                    // If everything is valid, perform the update 
                                    $id = DB::table('Activity')
                                        ->where('activityID', $activityID)
                                        ->update(['activityType' => $activityName,
                                            'assignDate' => $startDate,
                                            'dueDate' => $dueDate,
                                            'estTime' => $workload,
                                            'stresstimate' => $stresstimate]
                                        );
                                }
                                else
                                {
                                    
                                }
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    public function deleteActivity()
    {
        
    }

    /**
     * Purpose: Load all of the professors into the Professor select box
     * @return Activity Manager view containing list of professors
     */
    public function loadProfessors()
    {
        $query = DB::table('Professor')
                ->select('userID', 'lName', 'fName')
                ->get();

        $listOfProfs = array();

        // Loop through each query result and make an array
        for ($i = 0; $i < count($query); $i++)
        {
            $query[$i] = (array) $query[$i];
        }

        $listOfProfs['listOfProfs'] = $query;

        return view('CD/manageActivity', $listOfProfs);
    }

    /*
     * Purpose: Query the database for courses associated with a Professor's ID
     * @return a json object containing the courses
     */

    public function loadSelectedProfsCourses()
    {
        if (isset($_POST['profID']))
        {
            $prof = $_POST['profID'][0];
            $currentProf = $prof;

//            $coursesArray = DB::select('Select courseID, courseName from Course where courseID IN '
//                            . '( Select courseID from Section where sectionID IN '
//                            . '(SELECT sectionID from ProfessorSection WHERE userID = "'
//                            . $prof
//                            . '"))');
            
            $coursesArray = DB::select('Select sec.sectionID, cor.courseName from Course as cor '
                            . 'Join Section as sec on cor.courseID = sec.courseID '
                            . 'where sec.courseID IN(Select courseID from Section where sectionID IN '
                            . "(SELECT sectionID from ProfessorSection WHERE userID = '" .$prof ."')); ");

            return response()->json(['courses' => $coursesArray]);
        }
    }

    /*
     * Purpose: Query the database for Activities associated with the selected
     *          course.
     * @return a json object contating the activities for the selected course
     */

    public function loadSelectedCoursesActivities()
    {
        if (isset($_POST['courseID']))
        {
            $course = $_POST['courseID'][0];

            $activityArray = DB::select('SELECT activityID, activityType, assignDate, '
                            . 'dueDate, estTime, stresstimate FROM Activity where sectionID = "'
                            . $course . '"');

            return response()->json(['activities' => $activityArray]);
        }
    }
    
    public function loadSelectedActivity()
    {
        
    }

}
