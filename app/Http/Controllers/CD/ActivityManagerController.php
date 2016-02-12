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
        if (isset($_POST['activityName']))
        {
            $activityName = $_POST['activityName'];
            $startDate = $_POST['startDate'];
            $dueDate = $_POST['dueDate'];
            $workload = $_POST['workload'];
            $stresstimate = $_POST['stresstimate'];
            $sectionID = 3;
            
            $id = DB::table('Activity')->insertGetId(
                    
                    ['sectionID' => $sectionID,
                     'activityType' => $activityName, 
                     'assignDate' => $startDate,
                     'dueDate' => $dueDate,
                     'estTime' => $workload,
                     'stresstimate' => $stresstimate]
            );

            return response()->json(['activity' => $id]);
        }
    }

    public function editActivity()
    {
        
    }

    public function deleteActivity()
    {
        
    }

    /**
     * Load all of the professors into the Professor select box
     * @return Activity Manager view containing list of professors
     */
    public function loadProfessors()
    {
        $query = DB::table('Professor')
                ->select('userID', 'lName', 'fName')
                ->get();

        $listOfProfs = array();

        for ($i = 0; $i < count($query); $i++)
        {
            $query[$i] = (array) $query[$i];
        }

        $listOfProfs['listOfProfs'] = $query;

        return view('CD/manageActivity', $listOfProfs);
    }

    public function loadSelectedProfsCourses()
    {
        if (isset($_POST['profID']))
        {
            $prof = $_POST['profID'][0];

            $coursesArray = DB::select('Select courseID, courseName from Course where courseID = '
                            . '( Select courseID from Section where sectionID = '
                            . '(SELECT sectionID from ProfSection WHERE userID = "'
                            . $prof
                            . '"))');

            return response()->json(['courses' => $coursesArray]);
        }
    }

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
