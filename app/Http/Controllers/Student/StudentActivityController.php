<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StudentActivityRequest;
use App\StudentActivity;
use Illuminate\Support\Facades\Auth;
use DB;


/**
 * Purpose: The purpose of this controller is to control the way the student 
 * interacts with the program. The following is a list of what this controller
 * is responsible for:
 * 
 *  -student data entry
 *
 * @author cst229 Justin Lutzko
 */
class StudentActivityController extends Controller{
   
    public function _construct()
    {
        $this->middleware('guest'); 
    }

    /**
     * Purpose: This function shows all the activities the student will have
     * pop up on the student logs info dashboard.
     * 
     * @author CST229 Justin Lutzko
     */
    public function showAllActivities()
    {
        //Get the current authenticated user.
        $userID = Auth::user()->userID;

        //Query from the database, using a join from Activity and StudentActivity
        //to get the activityType
        $query = DB::table('StudentActivity')
            ->join('Activity', 'Activity.activityID', '=', 'StudentActivity.activityID')
            ->select('userID', 'Activity.activityID', 'timeSpent','stressLevel',
                    'StudentActivity.comments','timeEstimated','activityType', 'submitted')
            ->get();
        
        //Create an array
        $studentActivities = array();

        //Loop through each result.
        for($i = 0; $i < count($query); $i++)
        {
            //Cast $query from a StdClass to an array
            $query[$i] = (array) $query[$i];
        }
        //The view expects it in a associative array named 'studentActivities'
        $studentActivities['studentActivities'] = $query;
        
        //Return laravel magic - studentActivities will be used in acitvites.blade
        return view('Student/activities',$studentActivities);
    }
    
    
  
    /**
     * Purpose: Purpose of this function is to update the data submitted by the
     * student as it pertains to a particular assignment.
     * 
     * 
     * @param StudentActivityRequest $request
     * @return type
     */
    public function updateInfo(StudentActivityRequest $request)
    {   
       //Get the current authenticated user.
        $userID = Auth::user()->userID;
        
        //get activity id from hidden input field
        $activityID = $request->get('activityID');
        
        //Get the activity associaited with the student
        $studentActivity = StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $activityID)
                ->firstOrFail();
        
        //take in parameters passed in from form
        $studentActivity->timeSpent = $request->get('timeSpent');
        $studentActivity->stressLevel = $request->get('stressLevel');      
        $studentActivity->comments = $request->get('comments');
        $studentActivity->timeEstimated = $request->get('timeEstimated');
        $studentActivity->submitted = true;
        //Update information in the StudentActivity table
        StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $activityID)
                ->update($studentActivity['attributes']);
        
        //if successful, return success message
        return redirect('Student/activities')
            ->with('status', 'Your activity has been recorded!');
    }
    
    
}
