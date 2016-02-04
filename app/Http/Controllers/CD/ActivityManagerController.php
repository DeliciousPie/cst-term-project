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
use Illuminate\Support\Facades\Input;


/**
 * Handles the creating, editing, and deleting of different activities
 * from the manageActivities view.
 *
 * @author Anthony & Kendal
 */
class ActivityManagerControl extends Controller
{
    public function addActivity()
    {
        $activityName = Input::all();
        
        DB::insert('insert into Activity(activityType) values (?)', $activityName );
    }
    
    public function loadProfessors()
    {
        
        $listOfProfs = DB::table('Professor')->lists('lName');
        
    }
    
}
