<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Purpose: Loads standard pages for the CD user.
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
        //use both levels of middleware to confirm route groups.
        $this->middleware('cdmanager');
        
    }
    
    /**
     * Purpose: Purpose of this function is to load the CD dashboard when a 
     * user logs in with CD credentials.
     * 
     * @author Justin Lutzko CST229
     */
    public function loadDashboard()
    {
            $confirmed = Auth::user()->confirmed;
            
            if( $confirmed )
            {
                return view('CD/dashboard');
            }
            else
            {
                return  view('CD/register');
            }
    }
    
    
    /**
     * Purpose: This method checks to see if the user is a confirmed user or
     * not.  The confirmation is represented by an boolean column in the 
     * database.  Once the user registers the column is changed to a 1 else
     * they are unregistered represented by a zero.
     * 
     * @author Justin Lutzko cst229
     * 
     * @return String - Loads a view CDdashboard.
     */
    public function loadDashAfterConfirmation()
    {
        $user = User::find(Auth::user()->id);
                
        $user->confirmed = 1;
                
        $user->save();
        
        return view('CD/dashboard');
    }
    
    /**
     * Returns the manageActivity view
     * @return view
     */
    public function loadManageActivity()
    {
        return view('CD/manageActivity');
    }
}
