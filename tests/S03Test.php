<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CSVImportController;
use App\Http\Controllers\CD\CourseAssignmentController;
use Illuminate\Support\Facades\Artisan;

class S03Test extends TestCase
{
    /*
     * the comand below is used to remigrate and seed the db in one step 
     * 
     *   alias clearAndReseed='php artisan migrate:refresh --seed;'
     * 
     */

use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $this->addRequired();



        $CAC = new CourseAssignmentController();
        // prep post. 
        $_POST = ['courseID' => "CNET 295",
            'courseSection' => "CNET 295 sec L004",
            'courseSectionDescrip' => "",
            'studentList' => (array(
        0 => "Stu009")),
            'professorList' => (array(
        0 => "Pro011"))
        ];

        // submit with section selected and one student and one professor
        $successJsonObj = $CAC->assignToSection();


        // check that the section assignment was successfull 
        $this->assertTrue((strpos($successJsonObj, "CNET 295 sec L004 has been successfully added")) != false);

        $_POST = ['courseID' => "CNET 295",
            'courseSection' => "CNET 295 sec L004",
            'courseSectionDescrip' => "",
            'studentList' => (array(
        0 => "Stu009")),
            'professorList' => (array(
        0 => "Pro011"))
        ];
        // submit with section selected and one student and one professor
        $failCaseJsonObj = $CAC->assignToSection();

        // check that the section assignment was already submited and sends back that information
        $this->assertTrue((strpos($failCaseJsonObj, "CNET 295 sec 2 is already in the Data Base")) != false);
    }

    /*
     * used to add courses professors and students into the Database
     * that are required for this unit test 
     */

    protected function addRequired()
    {
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

        $_POST['courseSection'] = "CNET 295 sec L004";
        $_POST['Classes'] = "CNET 295";
        $_POST['Section'] = 'L004';

        $sectionID = $CAC->createSectionForStudents();

        $CAC->csvUploadStudentToDB($sectionID);
    }

}
