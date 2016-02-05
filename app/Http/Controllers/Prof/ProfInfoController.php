<?php

namespace App\Http\Controllers\Prof;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Professor;
use App\User;
use App\CD;
use Illuminate\Support\Facades\Input;


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
    
    public static function insertProf()
    {
                
        //If user has already been confirmed they don't need to register.
        $confirmed = Auth::user()->confirmed;
        if ($confirmed)
        {
        //  Send them to the dashboard
            return view('Prof/dashboard');
        }

        //if the passwords do not match
        if (Input::get('password') !== Input::get('confirmPassword'))
        {
            //show error
            return view('Prof/registerError');
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
             Professor::UpdateOrCreate(array(
            'id' => Auth::user()->id,
            'userID' => Auth::user()->userID,
            'fName' => Input::get('firstName'),
            'lName' => Input::get('lastName'),
            'educationalInstitution' => Input::get('school'),
            'areaOfStudy' => Input::get('areaOfStudy'),
            'email' => Input::get('email')));
                   
            
            //send Prof to the dashboard
            return view('Prof/dashboard');
        }
    } 
}
