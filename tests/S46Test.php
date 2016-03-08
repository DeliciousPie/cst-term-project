<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\ActivityManagerController;
use App\Http\Controllers\CD\CourseAssignmentController;

/**
 * Purpose: PHPunit testing for the AJAX calls
 */
class S46Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $AMC = new ActivityManagerController();
        
        // Test professors loading when refreshing the page
            $this->visit('CD/manageActivity');

            $profQuery = $AMC->loadProfessors();

            // Check that some profs were returned
            $this->assertNotNull($profQuery);
        
        
        // Test Courses of professors are loaded
            $_POST = ['profID' => 'Pro003'];
            
            // Load the courses
            $jsonResult = $AMC->loadSelectedProfsCourses();
            
            // Check that there are courses for that Pro003
            $this->assertTrue(($jsonResult != NULL));
        
            
        // Test that Activities are loaded based on selected course
            
            // Add a professor
            $_POST = ['profID' => 'Pro003'];
            
            $CAC = new CourseAssignmentController();

            $CSVFolder = base_path() . '/tests/FilesForTesting/S8/';

            /* Here are we testing Succesful uploading of professors */
            $_FILES = array('CourseCSV' => [
                    'name' => 'courses.csv',
                    'type' => 'application/vnd.ms-excel',
                    'tmp_name' => $CSVFolder . 'courses.csv',
                    'error' => 0,
                    'size' => 173
            ]);

            $CAC->csvUploadCoursesToDB();
            
            
            
            $id = DB::table('Activity')->insertGetId(
            ['sectionID' => 1,
                'activityType' => 'Test',
                'assignDate' => '2016-01-01 20:00',
                'dueDate' => '2016-02-02 20:00',
                'estTime' => '2',
                'stresstimate' => '1'
            ]);
            
            
            $jsonResult = $AMC->loadSelectedCoursesActivities();
            $this->assertTrue(($jsonResult != NULL));
            
        
        
        
        
        
    }
}
