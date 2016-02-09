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
//        Activity::insert([ 'activityID' => 1,
//            
//        ]);
//        
//        Activity::select();

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
                ->select('lName', 'fName')
                ->get();
        
        $listOfProfs = array();
        
        for($i = 0; $i < count($query); $i++ )
        {
            $query[$i] = (array) $query[$i];
        }
        
        $listOfProfs['listOfProfs'] = $query;
        
        return view('CD/manageActivity', $listOfProfs);
    }
    
    public function loadSelectedProfsCourses()
    {
        
    }
    
    public function loadSelectedCoursesActivities()
    {
        
    }



}
