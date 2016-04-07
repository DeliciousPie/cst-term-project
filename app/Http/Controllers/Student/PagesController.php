<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Purpose: Loads standard pages for the Student user.
 * 
 * @author Justin Lutzko CST229 
 */
class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('studentmanager');
      
    }
    
   /**
     * Purpose: Purpose of this function is to load the CD dashboard when a 
     * user logs in with CD credentials.
     * 
     * @author Justin Lutzko CST229
     */
    public function loadDashboard()
    {
       //Check if user is confirmed.  The user must be authenticated. 
       $confirmed = Auth::user()->confirmed;
       
       //Load dashboard or registeration form based on confirmation.
       if( $confirmed )
       {
           return view('Student/dashboard');
       }
       else
       {
           return  view('Student/register');
       }
    }
}
