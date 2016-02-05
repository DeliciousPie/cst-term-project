<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\StudentActivity;
use App\Activity;
use App\Role;
use App\Section;
use App\Course;
class S29Test extends TestCase
{
    /*
     * Purpose: Check if a completed StudentActivity field is filled out with same
     *      information when viewed
     * Author: Justin Lutzko, Dallen Barr
     */
    public function 
            testDataInFormFieldsMatchesTheDatabaseInBothTextAndDataType()
    {
        
        //Find user with id 200
        $user = User::find(200000);
        
        //Student Activity find with userID of 200 and activityID of 199
        $studentActivity = StudentActivity::where('activityID', 199000)
                ->where('userID', 200000);
        
        $activity = Activity::where('activityID', 199000);
        
        $course = Course::where('courseID', 'COMM102');
        
        $section = Section::where('sectionID', 199000)
                ->where('courseID', 'COMM102');
        
//If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        if( $studentActivity != null )
        {
           $studentActivity->delete(); 
        }

        if( $activity != null )
        {
           $activity->delete(); 
        }
        
        if( $course != null )
        {
            $course->delete();
        }
        
        if( $section != null )
        {
            $section->delete();
        }
        
        //Get student roles from db
        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();

        $user->attachRole($Student);
        
        $course = factory(Course::class)->create();
        $section = factory(Section::class)->create();
        $activity = factory(Activity::class)->create();
        $studentActivity = factory(StudentActivity::class)->create();
        
        
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('AssignmentTest')
             ->see(1)
             ->see(2)
             ->see(3)
             ->dontSee('Awesome');
    }
    
    /*
     * Purpose: Look to see if nothing is in a blank activity form and check
     *      the database values are empty.
     * Author: Justin Lutzko, Dallen Barr
     */
    public function testDataInFormFieldWhichHasNoDataIsEmptyWhenViewing()
    {
        //Find user with id 200
        $user = User::find(200000);
        
        //If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();

        $user->attachRole($Student);

        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->dontSee('Awesome');
    }

    /*
     * Purpose: Test the data retrieved from the database to populate the 
     *      Student Activity forms.
     * Author: Justin Lutzko, Dallen Barr
     */
    public function testSelectDataForStudentActivityController()
    {
        
    }
    
    
}
