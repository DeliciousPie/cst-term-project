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
        
        // adding activity so we have something to test with
        $_POST = ['activityName' => 'S23TestActivityAdded',
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
            'activityType' => 'S23TestActivityAdded'
        ]);
        
        // Get the id of the activity we just added
        $testActivityID = DB::table('Activity')
                ->where('activityType', 'S23TestActivityAdded')
                ->value('activityID');
                
        // Send a post across with the activity ID because that's what we use 
        // to delete the activity
        $_POST['activityID'] = $testActivityID;
        
        // Test deleting it now
        $AMC->deleteActivity();
        
        // Assert that we no longer se it in the database
        $this->notSeeInDatabase('Activity',
        [
            'activityType' => 'S23TestActivityAdded'
        ]);
    }
}
