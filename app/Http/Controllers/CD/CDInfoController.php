<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\User;
use App\CD; 
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
     * Purpose: A function that runs when a student is inserted, it runs validation on 
     * the various user input, and checks and sets the different session 
     * variables. 
     * 
     * @return views - if a validation fails, it goes back to the 
     *  CD info page.
     */
    public static function insertCD()
    {

        $confirmed = Auth::user()->confirmed;

        if ($confirmed)
        {
            return view('CD/dashboard');
        }

        //Check if the student number is set.
        //Validate the user email, checking for . and @ using a php function
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['isValidEmail'] = false;
            return view('CD/register');
        }

        if ($_POST['password'] === $_POST['confirmPassword'])
        {
            CD::create(array(
                'userID' => Auth::user()->userID,
                'fName' => Input::get('firstName'),
                'lName' => Input::get('lastName'),
                'educationalInstitution' => Input::get('school'),
                'areaOfStudy' => Input::get('areaOfStudy'),
                'email' => Input::get('email'))
            );

            $user = User::find(Auth::user()->id);
            $user->password = bcrypt(Input::get('password'));
            $user->name = Input::get('firstName');
            $user->email = Input::get('email');
            $user->confirmed = 1;
            $user->save();


            CDInfoController::CDConfirmation();

            return view('CD/dashboard');
        } else
        {
            //if the password comparison failed. Set this session variable
            //and it gets used on the studentInfoMain blade.
            $_SESSION['comparePasswords'] = false;
            return view('CD/register');
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
    public static function CDConfirmation()
    {
        //dd(Auth::user()->id);
        $user = User::find(Auth::user()->id);

        $user->confirmed = 1;

        $user->save();
    }

}
