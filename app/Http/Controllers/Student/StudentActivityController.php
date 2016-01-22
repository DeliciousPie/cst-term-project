<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StudentActivityRequest;
use App\StudentActivity;


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
    public function showAllActivities($userID='1234')
    {
        $studentActivity= StudentActivity::where('userID', '=', $userID)->get();
        
        $info = array();
        
        foreach( $studentActivity as $act )
        {
            array_push($info,$act['attributes']);
        }
        
        $studentActivities = $info;
        
        return view('Classes/ClassesMain',compact('studentActivities'));
    }
    
    
  
    
    public function updateInfo(StudentActivityRequest $request,
            $acitivityID = 1, $userID = 1234 )
    {
         
        
        $studentActivity = StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $acitivityID)
                ->firstOrFail();
        
        
      
        $studentActivity->timeSpent = $request->get('timeSpent');
        $studentActivity->stressLevel = $request->get('stressLevel');
        $studentActivity->comments = $request->get('comments');
        $studentActivity->timeEstimated = $request->get('timeEstimated');
              
        StudentActivity::where('userID', '=', $userID)
                ->where('activityID', '=', $acitivityID)
                ->update($studentActivity['attributes']);
        
        
        
        return redirect('/Classes')
            ->with('status', 'Your activity has been recorded!');
    }
}
