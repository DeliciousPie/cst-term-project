<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;

class ActivityManagerController extends Controller
{
    public function addActivity()
    {
        // sanitize all of the post fields
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $activityName = $_POST['activityName'];
        $startDate = $_POST['startDate'];
        $dueDate = $_POST['dueDate'];
        $workload = $_POST['workload'];
        $stresstimate = $_POST['stresstimate'];
        $prof = $_POST['profID'];

        // Check that all the fields are set
        if (isset($activityName) && isset($startDate) && isset($dueDate) && isset($workload) && isset($stresstimate) && isset($prof))
        {
            // Check if all are empty?
            
            // Check if activity name is valid
            if (strlen($activityName) > 0 && strlen($activityName) < 125)
            {
                // Check that startDate and dueDate are valid
                $startDateObj = new \DateTime($startDate);
                $dueDateObj = new \DateTime($dueDate);
                
                $interval = $startDateObj->diff($dueDateObj);
                $dateDiff = $interval->format('%R%a');
                
                // dueDate is greater than startDate
                if ( $dateDiff > 0 )
                {
                    // Check that workload is valid
                    if ($workload > 0 && $workload <= 800)
                    {
                        // Check that stresstimate is valid
                        if ($stresstimate >= 1 && $stresstimate <= 10)
                        {
                            //This is setting it to the first prof's section only. FIX
                            $results = DB::table('ProfSection')
                                    ->where('userID', $prof)
                                    ->first();

                            
                            
                            // Check that prof is valid????????????????????????????????????????                 FIXME
                            if (false)
                            {
                                // If everything is valid insert into the database
                                $id = DB::table('Activity')->insertGetId(
                                        ['sectionID' => $results->sectionID,
                                            'activityType' => $activityName,
                                            'assignDate' => $startDate,
                                            'dueDate' => $dueDate,
                                            'estTime' => $workload,
                                            'stresstimate' => $stresstimate]
                                );
                            }
                        }
                    }
                }
            }
        }
        
        return null; // response()->json(['activity' => $results]);
    }

    public function editActivity()
    {
        
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

            $coursesArray = DB::select('Select courseID, courseName from Course where courseID IN '
                            . '( Select courseID from Section where sectionID IN '
                            . '(SELECT sectionID from ProfSection WHERE userID = "'
                            . $prof
                            . '"))');

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
                            . 'dueDate, estTime, stresstimate FROM Activity where sectionID = '
                            . '(Select sectionID from Section where courseID = "'
                            . $course
                            . '")');

            return response()->json(['activities' => $activityArray]);
        }
    }

}
