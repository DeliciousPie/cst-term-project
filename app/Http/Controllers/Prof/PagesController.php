<?php

namespace App\Http\Controllers\Prof;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Purpose: Loads standard pages for the Prof user.
 * 
 * @author Justin Lutzko CST229 
 * 
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
        $this->middleware('profmanager');
      
    }
    
   /**
     * Purpose: Purpose of this function is to load the CD dashboard when a 
     * user logs in with Prof credentials.
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
           return view('Prof/dashboard');
       }
       else
       {
           return  view('Prof/register');
       }
    }

}
