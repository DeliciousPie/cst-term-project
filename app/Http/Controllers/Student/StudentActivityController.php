<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StudentActivityRequest;
use App\StudentActivity;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Course;

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
     * @author CST229 Justin Lutzko Dallen Barr CST218
     */
    public function showAllActivities()
    {
        $confirmed = Auth::user()->confirmed;
        
        if( !$confirmed )
        {
            return redirect('Student/dashboard');
        }
        
        //Get the current authenticated user.
        $userID = Auth::user()->userID;
        //query all the courses
        $courses = Course::all();
        
        //declare and array that will hold all the activities that apply to the
        //course.
        $studentAct = array();
        
        //For each course we want to find all the courses associated with it.
        foreach( $courses as $course)
        {
            //performt the query.
            //This query will look for all of the student activities assigned to
            //a student, in the spcified course.
            $queryResult = DB::table('StudentActivity')
                ->join('Activity', 'Activity.activityID', '=', 'StudentActivity.activityID')
                ->join('Section', 'Section.sectionID', '=' , 'Activity.sectionID')
                ->join('Course', 'Course.courseID', '=', 'Section.courseID')
                ->where('Course.courseId', '=', $course->courseID )
                ->where('StudentActivity.userID', '=', $userID)
                    ->select('userID', 'Activity.activityID', 'timeSpent','stressLevel',
                        'StudentActivity.comments','timeEstimated','activityType', 
                        'submitted', 'Course.courseID')
                ->get();
            
            //If the query result is not null add it to the $studentAct
            if($queryResult != null)
            {
                $studentAct[$course->courseID] = $queryResult;
            }
        }
        
        //Create an array
        $studentActivities = array();
        

        //The view expects it in a associative array named 'studentActivities'
        $studentActivities['studentActivities'] = 
                json_decode(json_encode($studentAct), true);

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
     * 
     * @author Justin Lutzko Dallen Barr
     * 
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
    
    /**
     * Purpose: This method checks to see if the user is a confirmed user or
     * not.  The confirmation is represented by an boolean column in the 
     * database.  Once the user registers the column is changed to a 1 else
     * they are unregistered represented by a zero.
     * 
     * @author Justin Lutzko cst229
     * 
     * @return String - Loads a view Student dashboard.
     */   
    public static function StudentConfirmation()
    {
        
        $user = User::find(Auth::user()->id);
                
        $user->confirmed = 1;
                
        $user->save();
    }
}
