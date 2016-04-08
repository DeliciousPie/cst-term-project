<?php

/**
 * Author Sean Young and Wes Reid
 * 
 */

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\CD;
use App\User;
use Illuminate\Support\Facades\Input;



class CDInfoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cdmanager');
    }

    /**
     * Purpose: A function that runs when a CD is inserted, it runs validation on 
     * the various user input, and checks and sets the different session 
     * variables. 
     * 
     * @return views - if a validation fails, it goes back to the 
     *  CD info page.
     */
    public static function insertCD()
    {
                
        //If user has already been confirmed they don't need to register.
        $confirmed = Auth::user()->confirmed;
        if ($confirmed)
        {
        //  Send them to the dashboard
            return redirect('CD/dashboard');
        }
                
            //Validate the user email, checking for . and @ using a php function
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                $_SESSION['isValidEmail'] = false;
                return view('CD/register');
            }
        //if the passwords do not match
        if (Input::get('password') !== Input::get('confirmPassword'))
        {
            //show error
            return view('CD/registerError');
        }
        
        
        else if(Input::get('password') === Input::get('confirmPassword'))
        {           
            //get form info
            $user = User::find(Auth::user()->id);            
            $user->password = bcrypt(Input::get('password'));
            $user->name = Input::get('firstName');
            $user->email = Input::get('email');              
            $user->confirmed = 1;
            $user->save();
            
        //  supplied information from the registration form.
             CD::create(array(
            'id' => Auth::user()->id,
            'userID' => Auth::user()->userID,
            'fName' => Input::get('firstName'),
            'lName' => Input::get('lastName'),
            'educationalInstitution' => Input::get('school'),
            'areaOfStudy' => Input::get('areaOfStudy'),
            'email' => Input::get('email')));

            
            //send CD to the dashboard
            return redirect('CD/dashboard');
        }
    }

    

}
