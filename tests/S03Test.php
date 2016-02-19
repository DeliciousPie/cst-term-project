<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CourseAssignmentController;

class S03Test extends TestCase
{
/*
 * the comand below is used to remigrate and seed the db in one step 
 * 
 *   alias clearAndReseed='php artisan migrate:refresh --seed;'
 * 
 */
    
    
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->addRequired();

        $CAC = new CourseAssignmentController();

        $_POST = ['courseID' => "CNET 295",
            'courseSection' => "2",
            'courseSectionDescrip' => "",
            'stuList' => (array(
        0 => "Stu009")),
            'profList' => (array(
        0 => "Pro011"))
        ];


        $successJsonObj = $CAC->assignToSection();

        //fwrite(STDERR, print_r($successJsonObj, TRUE));

        $this->assertTrue((strpos($successJsonObj, "CNET 295 sec 2 has been successfully added")) != false);

        $_POST = ['courseID' => "CNET 295",
            'courseSection' => "2",
            'courseSectionDescrip' => "",
            'stuList' => (array(
        0 => "Stu009")),
            'profList' => (array(
        0 => "Pro011"))
        ];
        $failCaseJsonObj = $CAC->assignToSection();
        
        
        $this->assertTrue((strpos($failCaseJsonObj, "CNET 295 sec 2 is already in the Data Base")) != false);
        
        
    }

    /*
     * used to add courses professors and students into the Database
     * that are required for this unit test 
     */

    protected function addRequired()
    {
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

        $CSVFolderPnS = base_path() . '/tests/FilesForTesting/S16/';

        /* Here are we testing Succesful uploading of professors */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'Professors.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolderPnS . 'professors.csv',
                'error' => 0,
                'size' => 173
        ]);

        $CAC->csvUploadProfessorsToDB();

        $_FILES = array('StudentsCSV' => [
                'name' => 'Students.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolderPnS . 'students.csv',
                'error' => 0,
                'size' => 173
        ]);

        $CAC->csvUploadStudentToDB();
    }

}
