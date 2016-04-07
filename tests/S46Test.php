<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\ActivityManagerController;
use App\Http\Controllers\CD\CSVImportController; 

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
            $_POST = ['profID' => 'Pro002'];
            
            // Load the courses
            $jsonCourseResult = $AMC->loadSelectedProfsCourses();
            
            // Check that there are courses for that Pro003
            $this->assertTrue(($jsonCourseResult != NULL));
        
        // Test an incorrect professor
            $_POST = ['profID' => 'NotAProf'];
            
            // Load the courses
            $jsonCourseResult = $AMC->loadSelectedProfsCourses();
            
            // Check that there are courses no courses for the incorrect prof
            $this->assertTrue(( empty( $jsonCourseResult->getData('courses')[0] )));
            
        // Test that Activities are loaded based on selected course
            
            // Add a professor
            $_POST = ['profID' => 'Pro002'];
            
            // Add a course
            $courseId = 'MEDC 100.0';
            $_POST = ['courseID' => $courseId];
            
            // Add courses
            $CAC = new CSVImportController();
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
            
            // Add a section
            DB::table('Section')->insert([
                'sectionID' => '1',
                'sectionType' => 'Test',
                'courseID' => 'MEDC 100.0',
                'date' => '2016-01-01 20:00',
                'created_at' => '2016-01-01 20:00',
                'updated_at' => '2016-02-02 20:00'
            ]);
            
            // Add a ProfSection
            DB::table('ProfessorSection')->insert([
                'userID' => 'Pro002',
                'sectionID' => '1',
                'created_at' => '2016-01-01 20:00',
                'updated_at' => '2016-02-02 20:00'
            ]);
            
            // Insert the Activity into the database
            DB::table('Activity')->insertGetId(
            ['sectionID' => 1,
                'activityType' => 'Test',
                'assignDate' => '2016-01-01 20:00',
                'dueDate' => '2016-02-02 20:00',
                'estTime' => '2',
                'stresstimate' => '1'
            ]);
            
            $jsonActivityResult = $AMC->loadSelectedCoursesActivities();
            $this->assertTrue(($jsonActivityResult != NULL));
            
        // Test failing when loading the activities. Test that the activies are empty
            $courseId = 'TestingNotACourse 100.0';
            $_POST = ['courseID' => $courseId];
        
            $jsonActivityResult = $AMC->loadSelectedCoursesActivities();
            $this->assertTrue(( empty( $jsonCourseResult->getData('activities')[0] )));
    }
}
