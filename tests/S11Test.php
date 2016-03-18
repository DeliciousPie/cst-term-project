<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CSVImportController;

class S11Test extends TestCase
{

    /**
     * ths runs tests for S 11 
     * CD Adds student to class list 
     *
     * @return void
     */
    public function testExample()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        // runs first example for adding to a clean database 
        $this->TestThreeNewStudents();
        // runs for a database that has duplicate entries of what is 
        // tying to be added 
        $this->TestThreeOld18NewStudents();
    }

    
    private function TestThreeNewStudents()
    {
        $CSVIC = new CSVImportController();

        // set up Post so that they are attatched when functions are ran 
        $_POST['Section'] = 'J03';
        $_POST['Classes'] = 'CDBM190';

        $sectionID = $CSVIC->createSectionForStudents();
        $CSVFolder = base_path() . '/tests/FilesForTesting/S11/';
        /* Here are we testing Succesful uploading of professors */
        $_FILES = array('StudentsCSV' => [
                'name' => 'Students03_users_for_course 001.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'Students03_users_for_course 001.csv',
                'error' => 0,
                'size' => 173
        ]);
        
        // test upload into database 
        $CSVIC->csvUploadStudentToDB($sectionID);

        // check to see that first and last student are added 
        $this->seeInDatabase('Student', ['userID' => 'Stu060']);
        $this->seeInDatabase('Student', ['userID' => 'Stu062']);
        // test to see that there are no mistakes of an extra user
        $this->notSeeInDatabase('Student', ['userID' => 'Stu063']);
        // check to see if the students are added to the course section table 
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu060','sectionID'=>'CDBM190 sec J03']);
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu062','sectionID'=>'CDBM190 sec J03']);
        $this->notSeeInDatabase('StudentInCourseSection', ['userID' => 'Stu063','sectionID'=>'CDBM190 sec J03']);
    }

    private function TestThreeOld18NewStudents()
    {
        $CSVIC = new CSVImportController();
        // set up Post so that they are attatched when functions are ran 
        $_POST['Section'] = 'J03';
        $_POST['Classes'] = 'CDBM190';
        $sectionID = $CSVIC->createSectionForStudents();
        $CSVFolder = base_path() . '/tests/FilesForTesting/S11/';
        /* Here are we testing Succesful uploading of professors */
        $_FILES = array('StudentsCSV' => [
                'name' => 'Students20course 001.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'Students20course 001.csv',
                'error' => 0,
                'size' => 173
        ]);
        
        
         // test upload into database 
        $CSVIC->csvUploadStudentToDB($sectionID);

        // check to see that first and last student are added 
        $this->seeInDatabase('Student', ['userID' => 'Stu060']);
        $this->seeInDatabase('Student', ['userID' => 'Stu062']);
        $this->seeInDatabase('Student', ['userID' => 'Stu064']);
        $this->seeInDatabase('Student', ['userID' => 'Stu080']);
        // test to see that there are no mistakes of an extra user
        $this->notSeeInDatabase('Student', ['userID' => 'Stu081']);
        // check to see if the students are added to the course section table 
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu060','sectionID'=>'CDBM190 sec J03']);
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu062','sectionID'=>'CDBM190 sec J03']);
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu064','sectionID'=>'CDBM190 sec J03']);
        $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu080','sectionID'=>'CDBM190 sec J03']);
        // check to see if extra entries have not been added 
        $this->notSeeInDatabase('StudentInCourseSection', ['userID' => 'Stu081','sectionID'=>'CDBM190 sec J03']);
    }

}
