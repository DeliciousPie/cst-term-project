<?php

namespace App\Http\Controllers\Student;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Input;

/**
 * The controller of the student info page. It calls the views, does validation
 *   on the user input, and utilizes both Students and Users
 * 
 * @author Anthony Festch & Sean Young
 */
class StudentInfoController extends Controller
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
     * A function that runs when a student is inserted, it runs validation on 
     *  the various user input, and checks and sets the different session 
     *  variables. 
     * @return views - if a validation fails, it goes back to the 
     *  student info page.
     */
    public static function insertStudent()
    {

        $confirmed = Auth::user()->confirmed;

        if ($confirmed)
        {
            return view('Student/dashboard');
        }

        //Check if the student number is set.
            //Validate the user email, checking for . and @ using a php function
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                $_SESSION['isValidEmail'] = false;
                return view('Student/register');
            }

            //Validates the age being sent from the form.
            if (isset($_POST['age']))
            {
                if ($_POST['age'] < 0 || $_POST['age'] > 150)
                {
                    $_SESSION['isValidAge'] = false;
                    return view('Student/register');
                }
            }

            if ($_POST['password'] === $_POST['confirmPassword'])
            {
                
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt(Input::get('password'));
                $user->name = Input::get('firstName');
                $user->email = Input::get('email');
                $user->confirmed = 1;
                $user->save();
                
                Student::where('userID', "=", Auth::user()->userID)->update(array(
                    'userID' => Auth::user()->userID,
                    'age' => Input::get('age'),
                    'areaOfStudy' => Input::get('areaOfStudy'),
                    'fName' => Input::get('firstName'),
                    'lName' => Input::get('lastName'),
                    'educationalInstitution' => Input::get('school'),
                    'email' => Input::get('email')));





                //StudentInfoController::StudentConfirmation();

                return view('Student/dashboard');
            } else
            {
                //if the password comparison failed. Set this session variable
                //and it gets used on the studentInfoMain blade.
                $_SESSION['comparePasswords'] = false;
                return view('Student/register');
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
     * @return String - Loads a view Student dashboard.
     */
    public static function StudentConfirmation()
    {

        $user = User::find(Auth::user()->id);

        $user->confirmed = 1;

        $user->save();
    }

}
