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

        
        /////    Test adding and deleting an activity   /////
        
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
                    $_POST['activityIDs'] = $testActivityID1;

                    // Test deleting it now
                    $AMC->deleteActivity();

                        // Assert that we no longer se it in the database
                        $this->notSeeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID1
                        ]);
            
            
        /////    Another test of adding and deleting an activity with different dates /////
        
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
                    $_POST['activityIDs'] = $testActivityID2;

                        // Test deleting it now
                        $AMC->deleteActivity();

                        // Assert that we no longer se it in the database
                        $this->notSeeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID2
                        ]);
                
                
        /////    Add 2 Activities and delete them    /////
                
                        // POST to create an activity
                        $_POST = ['activityName' => 'S23TestActivityAdded3',
                                'startDate' => '2016-03-06',
                                'dueDate' => '2017-06-09', 
                                'workload' => '2',
                                'stresstimate' => '3',
                                'profID' => 'Pro011',
                                'courseID' => '3'];

                        $AMC->addActivity();

                        // Get the id of the activity we just added
                        $testActivityID3 = DB::table('Activity')
                                ->where('activityType', 'S23TestActivityAdded3')
                                ->value('activityID');

                        // Assert that the Activity added is actualy in the database
                        $this->seeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID3
                        ]);

                        // POST to create another activity
                        $_POST = ['activityName' => 'S23TestActivityAdded4',
                                'startDate' => '2016-03-06',
                                'dueDate' => '2018-05-08', 
                                'workload' => '2',
                                'stresstimate' => '3',
                                'profID' => 'Pro011',
                                'courseID' => '3'];

                        $AMC->addActivity();

                        // Get the id of the activity we just added
                        $testActivityID4 = DB::table('Activity')
                                ->where('activityType', 'S23TestActivityAdded4')
                                ->value('activityID');

                        // Assert that the Activity added is actualy in the database
                        $this->seeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID4
                        ]);

                    $postArray = [$testActivityID3, $testActivityID4];

                    $_POST = ['activityIDs' => $postArray];


                    // Test deleting both now
                    $AMC->deleteActivity();

                        // Assert that we no longer the first activity in the database
                        $this->notSeeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID3
                        ]);

                        // Assert that we no longer the second activity in the database
                        $this->notSeeInDatabase('Activity',
                        [
                            'activityID' => $testActivityID4
                        ]);
                
        
        /////    Add 3 Activities and Delete the first 2     /////
        
                // POST to create an activity
                      $_POST = ['activityName' => 'S23TestActivityAdded5',
                              'startDate' => '2016-03-06',
                              'dueDate' => '2017-06-09', 
                              'workload' => '2',
                              'stresstimate' => '3',
                              'profID' => 'Pro011',
                              'courseID' => '3'];

                      $AMC->addActivity();

                      // Get the id of the activity we just added
                      $testActivityID5 = DB::table('Activity')
                              ->where('activityType', 'S23TestActivityAdded5')
                              ->value('activityID');

                      // Assert that the Activity added is actualy in the database
                      $this->seeInDatabase('Activity',
                      [
                          'activityID' => $testActivityID5
                      ]);

                      // POST to create another activity
                      $_POST = ['activityName' => 'S23TestActivityAdded6',
                              'startDate' => '2016-03-06',
                              'dueDate' => '2018-05-08', 
                              'workload' => '2',
                              'stresstimate' => '3',
                              'profID' => 'Pro011',
                              'courseID' => '3'];

                      $AMC->addActivity();

                      // Get the id of the activity we just added
                      $testActivityID6 = DB::table('Activity')
                              ->where('activityType', 'S23TestActivityAdded6')
                              ->value('activityID');

                      // Assert that the Activity added is actualy in the database
                      $this->seeInDatabase('Activity',
                      [
                          'activityID' => $testActivityID6
                      ]);

                      // POST to create another activity
                      $_POST = ['activityName' => 'S23TestActivityAdded7',
                              'startDate' => '2016-03-06',
                              'dueDate' => '2018-05-08', 
                              'workload' => '2',
                              'stresstimate' => '3',
                              'profID' => 'Pro011',
                              'courseID' => '3'];

                      $AMC->addActivity();

                      // Get the id of the activity we just added
                      $testActivityID7 = DB::table('Activity')
                              ->where('activityType', 'S23TestActivityAdded7')
                              ->value('activityID');

                      // Assert that the Activity added is actualy in the database
                      $this->seeInDatabase('Activity',
                      [
                          'activityID' => $testActivityID7
                      ]);
                
                      
                $postArray = [$testActivityID5, $testActivityID6];
                
                $_POST = ['activityIDs' => $postArray];
                
                
                // Test deleting both now
                $AMC->deleteActivity();

                // Assert that we no longer the first activity in the database
                $this->notSeeInDatabase('Activity',
                [
                    'activityID' => $testActivityID5
                ]);

                // Assert that we no longer the second activity in the database
                $this->notSeeInDatabase('Activity',
                [
                    'activityID' => $testActivityID6
                ]);

                // Assert that we can still see the last activity in the database
                $this->seeInDatabase('Activity',
                [
                    'activityID' => $testActivityID7
                ]);
            
          /////  Add 3 Activities and Delete the first and last one    /////
          
                  // POST to create an activity
                  $_POST = ['activityName' => 'S23TestActivityAdded8',
                          'startDate' => '2016-03-06',
                          'dueDate' => '2017-06-09', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID8 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded8')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID8
                  ]);

                  // POST to create another activity
                  $_POST = ['activityName' => 'S23TestActivityAdded9',
                          'startDate' => '2016-03-06',
                          'dueDate' => '2018-05-08', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID9 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded9')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID9
                  ]);

                  // POST to create another activity
                  $_POST = ['activityName' => 'S23TestActivityAdded10',
                          'startDate' => '2016-03-06',
                          'dueDate' => '2018-05-08', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID10 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded10')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID10
                  ]);


            $postArray = [$testActivityID8, $testActivityID10];

            $_POST = ['activityIDs' => $postArray];


            // Test deleting both now
            $AMC->deleteActivity();

            // Assert that we no longer the first activity in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityID' => $testActivityID8
            ]);

            // Assert that we no longer the second activity in the database
            $this->seeInDatabase('Activity',
            [
                'activityID' => $testActivityID9
            ]);

            // Assert that we can still see the last activity in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityID' => $testActivityID10
            ]);
               
            
          /////  Add 3 Activities and Delete the last 2     /////
          
                  // POST to create an activity
                  $_POST = ['activityName' => 'S23TestActivityAdded11',
                          'startDate' => '2016-03-06',
                          'dueDate' => '2019-02-02', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID11 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded11')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID11
                  ]);

                  // POST to create another activity
                  $_POST = ['activityName' => 'S23TestActivityAdded12',
                          'startDate' => '2016-02-06',
                          'dueDate' => '2018-05-04', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID12 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded12')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID12
                  ]);

                  // POST to create another activity
                  $_POST = ['activityName' => 'S23TestActivityAdded13',
                          'startDate' => '2016-03-04',
                          'dueDate' => '2018-05-06', 
                          'workload' => '2',
                          'stresstimate' => '3',
                          'profID' => 'Pro011',
                          'courseID' => '3'];

                  $AMC->addActivity();

                  // Get the id of the activity we just added
                  $testActivityID13 = DB::table('Activity')
                          ->where('activityType', 'S23TestActivityAdded13')
                          ->value('activityID');

                  // Assert that the Activity added is actualy in the database
                  $this->seeInDatabase('Activity',
                  [
                      'activityID' => $testActivityID13
                  ]);


            $postArray = [$testActivityID12, $testActivityID13];

            $_POST = ['activityIDs' => $postArray];


            // Test deleting both now
            $AMC->deleteActivity();

            // Assert that we no longer the first activity in the database
            $this->seeInDatabase('Activity',
            [
                'activityID' => $testActivityID11
            ]);

            // Assert that we no longer the second activity in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityID' => $testActivityID12
            ]);

            // Assert that we can still see the last activity in the database
            $this->notSeeInDatabase('Activity',
            [
                'activityID' => $testActivityID13
            ]);
                
                
                
                
    }
}
