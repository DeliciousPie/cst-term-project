<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Student\StudentActivityController;
use App\User;
use App\Role;
use App\Course;
use App\Section;
use App\Activity;
use App\StudentActivity;

class S32Test extends TestCase {

  
    
    /**
     * Purpose: Will test the page to confirm that the user can see the sutdent
     * activities page.
     * 
     * @author Justin Lutzko CST229 and Dallen Barr CST218
     */
    public function testShowAllActivities() {
        
        //Test to see if the student is redirected to the login page.
        $this->visit('Student/activities')
                ->see('Login')
                ->dontsee('Assignment');
        
        //If the user exists, delete it
        $user = User::find(200000);
        
        
        //If user exists delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();

        //Attach the role to the fake student.
        $user->attachRole($Student);
        
        //set confirmed attribute to false.
        $user->confirmed = false;
        
        //Should be directed to register.
        $this->visit('Student/activities')
             ->see('Register')
             ->dontsee('Assignment');
        
        //If the user exists, delete it
        $user = User::find(200000);
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();

        $user->attachRole($Student);
        
        //Should see the student activity page with all of the 
        //activity forms
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('Assignment')
             ->see('Assignment2')
             ->dontSee('Awesome');
    }
}
