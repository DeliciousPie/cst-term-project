<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Activity;

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
//        $this->visit('/manageActivity');
//        
//        // Check if the unit test activity is in the database
//        $activity = Activity::where('activityType', 'Activity Unit Test S25')
//                ->where();
//        
//        // If the activity exists, delete it
//        if ( $activity != null )
//        {
//            $activity->delete();
//        }
//        
//        // Insert the test activity into the Activity table
//        $testActivity = DB::table('Activity')->insertGetId(
//                ['sectionID' => 1,
//                    'activityType' => 'Activity Unit Test S25',
//                    'assignDate' => '',
//                    'dueDate' => '',
//                    'estTime' => 2,
//                    'stresstimate' => 2]
//        );
//
//        // Press the submit button
//        $this->press('modalSubmit');
    }

}
