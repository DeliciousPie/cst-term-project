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

class S22EditTaskTest extends TestCase
{
    /**
     * Test the modification of an activity.
     *
     * @return void
     */
    public function test()
    {
        //Reset the database
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed'); 
        
        // Create an Activty Manager Controller object
        $AMC = new ActivityManagerController();
        
        //Ensure the activity 99 doesn't already exist.
        $activity = Activity::where('activityID', 99);

        // If the activity exists, delete it
        if ( $activity != null )
        {
            $activity->delete();
        }
        
        //Create the activity that will be modified during the testing
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];

        $AMC->addActivity();

        // Assert that the Activity added is actualy in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 
        
////////////////////////Failures///////////////////////////////////
//
//////////////Activity Name/////////////
//
    // 1. Change the name to be blank 
        $_POST = ['activityName' => '',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);

    // 2. Change the name to be longer than the accepted length of 125 characters
        $_POST = ['activityName' => 'Thisisanamethatislongerthanonehundredtwenty'
            . 'fivecharactersanditshouldfailforthetestingofstorytwentytwowhichis'
            . 'editingactivitiesortests',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "Thisisanamethatislongerthanonehundredtwenty'
            . 'fivecharactersanditshouldfailforthetestingofstorytwentytwowhichis'
            . 'editingactivitiesortests",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    ////////////Date/////////////
        
    // 3. Change the start date to a date after the due date 
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-12',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-12",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 4. Change the start date to be empty
        $_POST = ['activityName' => 'S22Test',
                'startDate' => '',
                'activityID' => 99,
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 5. Change the due date to be before the start date
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-10', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-10", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 6. Change the due date to be empty
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 7. Change the start dates month to be 13
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-13-11',
            //Making sure it fails on the 13th month, not the difference.
                'dueDate' => '2016-14-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-13-11",
            'dueDate' => "2016-14-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 8. Change the due dates month to be 13
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-1-11',
                'dueDate' => '2016-13-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-1-11",
            'dueDate' => "2016-13-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 9. Change the start dates day to be 32
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-1-32',
                'dueDate' => '2016-2-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-1-32",
            'dueDate' => "2016-2-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 10. Change the due dates day to be 32
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-1-11',
                'dueDate' => '2016-2-32', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-1-11",
            'dueDate' => "2016-2-32", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 11. Change the start dates day to be 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-1-0',
                'dueDate' => '2016-2-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-1-0",
            'dueDate' => "2016-2-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 12. Change the due dates day to be 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-1-11',
                'dueDate' => '2016-2-0', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-1-11",
            'dueDate' => "2016-2-0", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);        
        
    // 13. Change the start dates month to be 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-0-11',
                'dueDate' => '2016-2-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-0-11",
            'dueDate' => "2016-2-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 

    // 14. Change the due dates month to be 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-0-5',
                'dueDate' => '2016-0-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-0-5",
            'dueDate' => "2016-0-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 15. Test the min start date of 0000-00-00
        $_POST = ['activityName' => 'S22Test', 
                'activityID' => 99,
                'startDate' => '0000-00-00',
                'dueDate' => '2016-2-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "0000-00-00",
            'dueDate' => "2016-2-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 
        
    // 16. Test the min due date of 0000-00-00
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '0000-00-00',
                'dueDate' => '0000-00-00', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "0000-00-00",
            'dueDate' => "0000-00-00", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 
        
    // 17. Test the max start date of 2999-12-31, by using 3000-01-01
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '3000-01-31',
                'dueDate' => '3000-02-22', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "3000-01-31",
            'dueDate' => "3000-02-22", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 
        
    // 18. Test the max due date of 2999-12-31, by using 3000-01-01
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2999-12-31',
                'dueDate' => '3000-01-01', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        try
        {
            $AMC->editActivity();
        } catch (Exception $ex) {    
        }
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2999-12-31",
            'dueDate' => "3000-01-01", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]); 
    
        ////////////Workload/////////////
        
    // 19. Test the workload min of 1 by using 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '0',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "0",
            'stresstimate' => "3"
        ]); 
        
    // 20. Test the workload max of 800 by using 801
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '801',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "801",
            'stresstimate' => "3"
        ]); 
        
    // 21. Test the negative workload
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '-10',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "-10",
            'stresstimate' => "3"
        ]); 
        
    ////////////Stresstimate/////////////
        
    // 22. Test the min stresstimate of 1 by using 0
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '10',
                'stresstimate' => '0',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "10",
            'stresstimate' => "0"
        ]); 
        
    // 23. Test the max stresstimate of 10 by using 11
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '10',
                'stresstimate' => '11',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "10",
            'stresstimate' => "11"
        ]); 
        
    // 24. Test the negative stresstimate
        $_POST = ['activityName' => 'S22Test',
                'activityID' => 99,
                'startDate' => '2016-01-01',
                'dueDate' => '2016-01-01', 
                'workload' => '10',
                'stresstimate' => '-11',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is not actually in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => "S22Test",
            'activityID' => 99,
            'assignDate' => "2016-01-01",
            'dueDate' => "2016-01-01", 
            'estTime' => "10",
            'stresstimate' => "-11"
        ]); 
        
////////////////////////Success///////////////////////////////////
//
////////////////Activity Name////////////////////
//
//

    // 1. Change the name to a single letter and edit the activity
        $_POST = ['activityName' => 'A',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "A",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
    
        
    // 2. Change the name to a value that has 124 characters 
        $_POST = ['activityName' => 'Thisisanamethatislongerthanonehundred'
            . 'twentyfivecharactersanditshouldfailforthetestingofstorytwent'
            . 'ytwowhichiseditingactivitie',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "Thisisanamethatislongerthanonehundredtwenty"
            . "fivecharactersanditshouldfailforthetestingofstorytwentytwo"
            . "whichiseditingactivitie",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 3. Change the name to something normal and edit the activity
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
            
    /////////////Workload////////////////
        
    // 4. Change the workload to 1, the accepted minimum
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '1',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "1",
            'stresstimate' => "3"
        ]);
        
    // 5. Change the workload to 800, the accepted maximum
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '800',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "800",
            'stresstimate' => "3"
        ]);
        
    // 6. Change the workload to a normal value
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '24',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "24",
            'stresstimate' => "3"
        ]);
        
    /////////////Stresstimate///////////////
        
    // 7. Change the stresstimate to a 1, the accepted minimum
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '24',
                'stresstimate' => '1',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "24",
            'stresstimate' => "1"
        ]);
        
    // 8. Change the stresstimate to a 10, the accepted max
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '24',
                'stresstimate' => '10',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "24",
            'stresstimate' => "10"
        ]);
        
    // 9. Change the stresstimate to a 6, a normal value
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '24',
                'stresstimate' => '6',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "24",
            'stresstimate' => "6"
        ]);
        
    // 10. Modify all values to normal values
        $_POST = ['activityName' => 'Assignment3',
                'activityID' => 99,
                'startDate' => '2016-12-12',
                'dueDate' => '2016-12-12', 
                'workload' => '26',
                'stresstimate' => '8',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "Assignment3",
            'activityID' => 99,
            'assignDate' => "2016-12-12",
            'dueDate' => "2016-12-12", 
            'estTime' => "26",
            'stresstimate' => "8"
        ]);
     
//////////////Dates//////////////////
        
    // 11. Change the start date and due date to values that are the same
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-01-11',
                'dueDate' => '2016-01-11', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-01-11",
            'dueDate' => "2016-01-11", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 12. Change the start date to the max
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2999-12-30',
                'dueDate' => '2999-12-30', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2999-12-30",
            'dueDate' => "2999-12-30", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 13. Change the due date to the max
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '2016-12-30',
                'dueDate' => '2999-12-30', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "2016-12-30",
            'dueDate' => "2999-12-30", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 14. Change the start date to the min
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '0000-01-01',
                'dueDate' => '2016-12-31', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "0000-01-01",
            'dueDate' => "2016-12-31", 
            'estTime' => "3",
            'stresstimate' => "3"
        ]);
        
    // 15. Change the start and due dates to the min
        $_POST = ['activityName' => 'S22TestChanged',
                'activityID' => 99,
                'startDate' => '0000-01-01',
                'dueDate' => '0000-01-01', 
                'workload' => '3',
                'stresstimate' => '3',
                'profID' => 'Pro011',
                'courseID' => '3'];
            
        $AMC->editActivity();
            
        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => "S22TestChanged",
            'activityID' => 99,
            'assignDate' => "0000-01-01",
            'dueDate' => "0000-01-01", 
            'estTime' => "3",
            'stresstimate' => "3"
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
