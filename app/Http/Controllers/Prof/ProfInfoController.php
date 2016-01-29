<?php

namespace App\Http\Controllers\Prof;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\User;


class ProfInfoController extends Controller
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
     * Purpose: A function that runs when a student is inserted, it runs validation on 
     * the various user input, and checks and sets the different session 
     * variables. 
     * 
     * @return views - if a validation fails, it goes back to the 
     *  CD info page.
     */
    public static function insertStudent()
    {
        
        $confirmed = Auth::user()->confirmed;
        
        if( $confirmed )
        {
            return view('Prof/dashboard');
        }
        
        //Check if the student number is set.
        if ( isset($_POST['userID']) )
        {
            //Validate the user email, checking for . and @ using a php function
            if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )
            {
                $_SESSION['isValidEmail'] = false;
                return view('Prof/register');
            }
                    
            if($_POST['password'] === $_POST['confirmPassword'])
            {      
                Prof::create(array(
                    'id' => Auth::user()->id,
                    'userID' => $_POST['profNumber'],  
                    'fName' => $_POST['firstName'], 
                    'lName' => $_POST['lastName'], 
                    'educationalInstitution' => $_POST['school'],
                    'areaOfStudy' => $_POST['areaOfStudy'],
                    'email' => $_POST['email']));
                
                $user = User::find(Auth::user()->id);
                
                $user->password = bcrypt($_POST['password']);
                
                $user->save();
                
                ProfInfoController::ProfConfirmation();
            
                return view('Prof/dashboard');
            }
            else
            {
                //if the password comparison failed. Set this session variable
                    //and it gets used on the studentInfoMain blade.
                $_SESSION['comparePasswords'] = false;
                return view('Prof/register');
            }
        }
        else
        {
            //Redirects back to the page if the POST fails.
            return view('Prof/register');
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
     * @return String - Loads a view Prof dashboard.
     */   
    public static function ProfConfirmation()
    {
        //dd(Auth::user()->id);
        $user = User::find(Auth::user()->id);
                
        $user->confirmed = 1;
                
        $user->save();
    } 
}
