<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CourseAssignmentController;
use App\Http\Controllers\CD\CSVImportController;
use Illuminate\Support\Facades\Artisan;

class S33Test extends TestCase
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

        $this->addCourseOnly();

        $CAC = new CourseAssignmentController();

        $_POST['courseSection'] = "CNET 295 sec L004";
        $_POST['Classes'] = "CNET 295";
        $_POST['Section'] = 'L004';

        $ReturnArray = $CAC->getProfessorAndStudent();
        // no professors in database
        $this->assertTrue((strpos($ReturnArray, '"professors":[]')) != false);
        // no students in database
        $this->assertTrue((strpos($ReturnArray, '"students":[]')) != false);


        $this->addProfessorAndStudent();
        $ReturnArrayWithProfandStu = $CAC->getProfessorAndStudent();

        // there are students in database
        $this->assertTrue((strpos($ReturnArrayWithProfandStu, '"professors":[{"fName":"Scottie",')) != false);
        // section from database show up. 
        $this->assertTrue((strpos($ReturnArrayWithProfandStu, '"students":[{"fName":"Mark",')) != false);
    }

    /*
     * used to add courses professors and students into the Database
     * that are required for this unit test 
     */

    protected function addProfessorAndStudent()
    {
        $CAC = new CSVImportController();

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

        $sectionID = $CAC->createSectionForStudents();

        $CAC->csvUploadStudentToDB($sectionID);
    }

    private function addCourseOnly()
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
    }

}
