<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\ActivityManagerController;

class S23Test extends TestCase
{
    /**
     * Purpose: Unit tests for S23
     * 
     * Author: Kendal Keller
     * Date: 4/5/2016
     *
     * @return void
     */
    public function testExample()
    {        
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
        // Create an Activty Manager Controller object
        $AMC = new ActivityManagerController();

        
        /// Test adding and deleting an activity ///
        
                // POST to create an activity
                $_POST = ['activityName' => 'S23TestActivityAdded1',
                        'startDate' => '2050-01-01',
                        'dueDate' => '2051-01-01', 
                        'workload' => '3',
                        'stresstimate' => '3',
                        'profID' => 'Pro011',
                        'courseID' => '3'];

                $AMC->addActivity();

                // Get the id of the activity we just added
                $testActivityID1 = DB::table('Activity')
                        ->where('activityType', 'S23TestActivityAdded1')
                        ->value('activityID');
                
                // Assert that the Activity added is actualy in the database
                $this->seeInDatabase('Activity',
                [
                    'activityID' => $testActivityID1
                ]);
                
                // Send a post across with the activity ID because that's what 
                // we use to delete the activity
                $_POST['activityID'] = $testActivityID1;

                // Test deleting it now
                $AMC->deleteActivity();

                // Assert that we no longer se it in the database
                $this->notSeeInDatabase('Activity',
                [
                    'activityID' => $testActivityID1
                ]);
            
            
        /// Another test of adding and deleting an activity with different dates ///
        
                // POST to create an activity
                $_POST = ['activityName' => 'S23TestActivityAdded2',
                        'startDate' => '2017-03-06',
                        'dueDate' => '2017-06-09', 
                        'workload' => '3',
                        'stresstimate' => '3',
                        'profID' => 'Pro011',
                        'courseID' => '3'];

                $AMC->addActivity();

                // Get the id of the activity we just added
                $testActivityID2 = DB::table('Activity')
                        ->where('activityType', 'S23TestActivityAdded2')
                        ->value('activityID');
                
                // Assert that the Activity added is actualy in the database
                $this->seeInDatabase('Activity',
                [
                    'activityID' => $testActivityID2
                ]);
                
                // Send a post across with the activity ID because that's what 
                // we use to delete the activity
                $_POST['activityID'] = $testActivityID2;
                
                // Test deleting it now
                $AMC->deleteActivity();

                // Assert that we no longer se it in the database
                $this->notSeeInDatabase('Activity',
                [
                    'activityID' => $testActivityID2
                ]);
                
    }
}
