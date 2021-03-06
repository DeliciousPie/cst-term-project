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

    public function resetDB()
    {          
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }
    
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
        $user = factory(User::class)->create([
            'id' => 200000,
            'name' => "Dallen",
            'email' => "Dallen@mail.com",
            'userID' => "696969",
            'password' => bcrypt(str_random(10)),
            'confirmed' => true,
            'remember_token' => str_random(10),
        ]);;

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
        $user = factory(User::class)->create([
            'id' => 200000,
            'name' => "Dallen",
            'email' => "Dallen@mail.com",
            'userID' => "696969",
            'password' => bcrypt(str_random(10)),
            'confirmed' => true,
            'remember_token' => str_random(10),
        ]);

        $user->attachRole($Student);
        
        $user->confirmed = true;

        //Student Activity find with userID of 200 and activityID of 199
        $studentActivity = StudentActivity::where('activityID', 199000)
                ->where('userID', "696969");
        
        if( $studentActivity != null )
        {
            $studentActivity->delete();
        }
        
        $studentActivity = factory(StudentActivity::class)->create([
                        'userID' => "696969",
            'activityID' => 199000,
            'timespent' => 1,
            'stressLevel' => 2,
            'comments' => "Test",
            'timeEstimated' => 3,
            'submitted' => 1,
        ]);
        
        //Should see the student activity page with all of the 
        //activity forms
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('AssignmentTest')
             ->dontSee('Awesome');
       
        if( $studentActivity != null )
        {
           $studentActivity
                ->where('activityID',199000)
                ->where('userID', "696969")
                ->delete();
        }
    }
}
