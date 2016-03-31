<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Activity;
use App\Http\Controllers\CD\ActivityManagerController;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\CD;
use App\Role;


/**
 * Purpose: PHPunit test for adding Activity into database
 */
class S25Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {   
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
        // Create an Activty Manager Controller object
        $AMC = new ActivityManagerController();
        
        // check that we can insert into the Activity table
        
            // Check if the unit test activity is in the database
            $activity = Activity::where('activityType', 'ActivityUnitTestS25');

            // If the activity exists, delete it
            if ( $activity != null )
            {
                $activity->delete();
            }

            // Insert the test activity into the Activity table
            $testActivity = DB::table('Activity')->insertGetId(
                    ['sectionID' => 1,
                        'activityType' => 'S25Test1',
                        'assignDate' => '2050-01-01',
                        'dueDate' => '2051-01-01',
                        'estTime' => 2,
                        'stresstimate' => 2]
            );
            
            $this->seeInDatabase('Activity',
                    [
                        'activityType' => 'S25Test1'
                    ]);
            
////////////////////////Success///////////////////////////////////
        // adding activity successful added
            $_POST = ['activityName' => 'S25TestActivityAdded',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                    'workload' => '3',
                    'stresstimate' => '3',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'S25TestActivityAdded'
            ]);            
            
////////////////////////Workload///////////////////////////////////
        // Adding Activity WORKLOAD boundary cases
             $_POST = ['activityName' => 'WorkloadBoundary1',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                 //Workload is 1
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'WorkloadBoundary1'
            ]);      
            
            $_POST = ['activityName' => 'WorkloadBoundary2',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                 //Workload is 800
                    'workload' => '800',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'WorkloadBoundary2'
            ]);
            
        // adding activity FAIL because of workload
            $_POST = ['activityName' => 'WorkloadErrorTooHigh',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                //Workload Too High
                    'workload' => '801',
                    'stresstimate' => '3',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'WorkloadErrorTooHigh'
            ]);      

            $_POST = ['activityName' => 'WorkloadErrorTooLow',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                //Workload Too Low
                    'workload' => '0',
                    'stresstimate' => '3',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'WorkloadErrorTooLow'
            ]);     
            
        
////////////////////////Stresstimate///////////////////////////////////
            // Adding Activity STRESSTIMATE boundary cases
             $_POST = ['activityName' => 'StresstimateBoundary1',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                    'workload' => '1',
                 //Stresstimate is 1
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'WorkloadBoundary1'
            ]);      
            
            $_POST = ['activityName' => 'StresstimateBoundary2',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                    'workload' => '800',
                //Stresstimate is 10
                    'stresstimate' => '10',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'WorkloadBoundary2'
            ]);
            
        // adding activity fails because of STRESSTIMATE
            $_POST = ['activityName' => 'StresstimateErrorTooHigh',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01',
                    'workload' => '5',
                 //Stresstimate Too High
                    'stresstimate' => '11',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'StresstimateErrorTooHigh'
            ]);      

            $_POST = ['activityName' => 'StresstimateErrorTooLow',
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01',
                    'workload' => '5',
                //Stresstimate too low
                    'stresstimate' => '0',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'StresstimateErrorTooLow'
            ]);
            
//////////////////////////Date///////////////////////////////////
            
            // Adding Activity Due Date boundary cases - Exact Same
             $_POST = ['activityName' => 'DateBoundary1',
                 //Dates are the same
                    'startDate' => '2050-01-01',
                    'dueDate' => '2050-01-01', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'DateBoundary1'
            ]);
            
            // adding activity FAILS because the due date is before the start
            $_POST = ['activityName' => 'DateErrorDueBeforeStart',
                //Due date before start date
                    'startDate' => '2051-01-01',
                    'dueDate' => '2050-01-01',
                    'workload' => '5',
                    'stresstimate' => '9',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'DateErrorDueBeforeStart'
            ]);      

            $_POST = ['activityName' => 'DateMaxedOut',
                    'startDate' => '2050-01-01',
                    'dueDate' => '9999-12-31',
                    'workload' => '5',
                    'stresstimate' => '2',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            // Assert that the Activity added is actualy in the database
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'DateMaxedOut'
            ]);  
            
            // Min Start year date
            $_POST = ['activityName' => 'MinStartDAte',
                'startDate' => '0000-00-00',
                'dueDate' => '2050-01-01',
                'workload' => '5',
                'stresstimate' => '2',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'MinStartDAte'
            ]); 
            
            // Max start date year
            $_POST = ['activityName' => 'MonthYearMaxedOut',
                'startDate' => '9999-05-04',
                'dueDate' => '2050-06-04', 
                'workload' => '1',
                'stresstimate' => '1',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'MonthYearMaxedOut'
            ]);
            
            
            // Test min due date values
            $_POST = ['activityName' => 'DueDateMin',
                'startDate' => '2050-01-01',
                'dueDate' => '0000-00-00',
                'workload' => '5',
                'stresstimate' => '2',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'DueDateMin'
            ]);  
            
            // Real case scenarios 
            $_POST = ['activityName' => 'MonthsFlippedPass',
                    'startDate' => '2050-04-01',
                    'dueDate' => '2050-06-01', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'MonthsFlippedPass'
            ]);  
            
            // Fail case of months flipped
            $_POST = ['activityName' => 'MonthsFlippedFailed',
                    'startDate' => '2050-06-01',
                    'dueDate' => '2050-04-01', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'MonthsFlippedFailed'
            ]);
            
            // Month and day confused pass
            $_POST = ['activityName' => 'DaysFlippedPass',
                    'startDate' => '2050-04-06',
                    'dueDate' => '2050-06-04', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->seeInDatabase('Activity',
            [
                'activityType' => 'DaysFlippedPass'
            ]);

            // Month and day confused fail
            $_POST = ['activityName' => 'DaysFlippedFail',
                    'startDate' => '2050-06-04',
                    'dueDate' => '2050-04-06', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'DaysFlippedFail'
            ]);  
            
            // Reverse order
            $_POST = ['activityName' => 'WholeDateFlipped',
                    'startDate' => '2050-06-04',
                    'dueDate' => '03-05-2020', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            $AMC->addActivity();
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'WholeDateFlipped'
            ]);
            
            // Start Date Month maxed out
            $_POST = ['activityName' => 'MonthMaxedOut',
                    'startDate' => '2050-99-04',
                    'dueDate' => '2050-06-04', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            try
            {
                $AMC->addActivity();
            } catch (Exception $ex) {    
            }
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'MonthMaxedOut'
            ]);
            
            // Start Date Day maxed out
            $_POST = ['activityName' => 'DayMaxedOut',
                    'startDate' => '2050-04-99',
                    'dueDate' => '2050-06-04', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            try
            {
                $AMC->addActivity();
            } catch (Exception $ex) {    
            }
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'DayMaxedOut'
            ]);
            
            // Due Date Month maxed out
            $_POST = ['activityName' => 'MonthMaxedOut',
                    'startDate' => '2050-04-04',
                    'dueDate' => '2050-99-04', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            try
            {
                $AMC->addActivity();
            } catch (Exception $ex) {    
            }
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'MonthMaxedOut'
            ]);
            
            // Due Date Day maxed out
            $_POST = ['activityName' => 'DayMaxedOut',
                    'startDate' => '2050-04-04',
                    'dueDate' => '2050-04-99', 
                    'workload' => '1',
                    'stresstimate' => '1',
                    'profID' => 'Pro011',
                    'courseID' => '3'];
            
            try
            {
                $AMC->addActivity();
            } catch (Exception $ex) {    
            }
            
            $this->notSeeInDatabase('Activity',
            [
                'activityType' => 'DayMaxedOut'
            ]);
            
    }
    
    /**
     * Purpose: To create a user to log on a a CD.  Re-occurs all the time.
     * 
     * @return CD user
     * 
     * @author Jusitn Lutzko 
     * 
     * @date Feb 21 2016
     */
    public function createUser()
    {
        //Find user with id 200000
        $user = User::find(200000);
        
        //If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $CD = Role::find(1);
        $user = factory(User::class)->create();

        
        //Attach the student role to the user.
        $user->attachRole($CD);
       return $user;
    }

}
