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
                ->where('userID', "696969");
        
        $activity = Activity::where('activityID', 199000);
        
        $course = Course::where('courseID', 'COMM102');
        
        $section = Section::where('sectionID', 199000)
                ->where('courseID', 'COMM102');
        
        //If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //If the studentActivity exists delete it.
        if( $studentActivity != null )
        {
           $studentActivity->delete(); 
        }
        
        //If the activity exists delete it.
        if( $activity != null )
        {
           $activity->delete(); 
        }
        
        //If the course exists delete it.
        if( $course != null )
        {
            $course->delete();
        }
        
        //If the section exists delete it.
        if( $section != null )
        {
            $section->delete();
        }
        
        //Get student roles from db
        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();
        
        //Attach the student role to the user.
        $user->attachRole($Student);
        
        //Create the needed fake data.
        $course = factory(Course::class)->create();
        $section = factory(Section::class)->create();
        $activity = factory(Activity::class)->create();
        $studentActivity = factory(StudentActivity::class)->create();
        
        //Look on the page too see if we can find the fake student activity.
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('AssignmentTest')
             ->see(1)
             ->see(2)
             ->see(3)
             ->see('Submitted')
             //this should not be on the page
             ->dontSee('Awaiting Submission');
        
        //Look in Database to see if the fake data exists.
        $this->seeInDatabase('StudentActivity', 
                ['userID' => '696969',
                    'activityID' => 199000,
                    'timespent' => 1,
                    'stressLevel' => 2,
                    'comments' => "Test",
                    'timeEstimated' => 3,
                    'submitted' => 1]);
    }
    
    /*
     * Purpose: Look to see if nothing is in a blank activity form and check
     *      the database values are empty.
     * Author: Justin Lutzko, Dallen Barr
     */
    public function testDataInFormFieldWhichHasNoDataIsEmptyWhenViewing()
    {
        //Find user with id 200
        $user = User::find(5);
        
        $user->confirmed = true;
        
        //This is seeded data that should have nothing submitted.
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('Assignment2')
             ->see('Assignment')
             ->see('Awaiting Submission')
             ->see(0)
             ->see(0)
             ->see(0)
             ->dontSee('Awesome');
        
        //You should see the seeded data in the data base.
        $this->seeInDatabase('StudentActivity', 
                ['userID' => '12347',
                    'activityID' => 2,
                    'timespent' => 21,
                    'stressLevel' => 7,
                    'timeEstimated' => 15,
                    'submitted' => 0]);
    }   
    
    /**
     * Purpose: The purpose of this function is to test if there are no 
     * activities associated with a student no activities will show up.
     * 
     * @author Justin Lutzko,Dallen Barr
     */
    public function testIfNoActivitiesAssigned()
    {
        //find user with the id 5
        $user = User::find(6);
        //Confirm them
        $user->confirmed = true;
        //Log them in
        $this->actingAs($user)
                ->withSession(['foo' => 'bar'])
                ->visit('Student/activities')
                ->see('Student Activities')
                ->see('No activities')
                ->dontSee('Awesome');
    }
}
