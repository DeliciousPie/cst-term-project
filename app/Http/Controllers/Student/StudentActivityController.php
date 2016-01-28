<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StudentActivityRequest;
use App\StudentActivity;
use Illuminate\Support\Facades\Auth;


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
        $userID = Auth::user()->userID;
        
        $studentActivity= StudentActivity::where('userID', '=', $userID)->get();
        
        $info = array();
        
        foreach( $studentActivity as $act )
        {
            array_push($info,$act['attributes']);
        }
        
        $studentActivities = $info;
        
        return view('Student/activities',compact('studentActivities'));
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
       //
        $activityID = $request->get('activityID');
        
        $studentActivity = StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $activityID)
                ->firstOrFail();
        
        $studentActivity->timeSpent = $request->get('timeSpent');
        $studentActivity->stressLevel = $request->get('stressLevel');
        $studentActivity->comments = $request->get('comments');
        $studentActivity->timeEstimated = $request->get('timeEstimated');
              
        StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $activityID)
                ->update($studentActivity['attributes']);

        return redirect('Student/activities')
            ->with('status', 'Your activity has been recorded!');
    }
}
