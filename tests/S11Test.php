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

        $studentsIdAddstartNum = 60;
        $studentsIdAddendNum = 63;
        $studentsIdNotInNum = 80;

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
        // the user id is from 60 to 80 
        for ($i = $studentsIdAddstartNum; $i < $studentsIdAddendNum; $i++)
        {
            $this->seeInDatabase('Student', ['userID' => 'Stu0' . $i]);
        }
        // test to see that there are no mistakes of an extra user
        for ($i = $studentsIdAddendNum; $i < $studentsIdNotInNum; $i++)
        {
            $this->notSeeInDatabase('Student', ['userID' => 'Stu0' . $i]);
        }

        // check to see if the students are added to the course section table
        for ($i = $studentsIdAddstartNum; $i < $studentsIdAddendNum; $i++)
        {
            $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu0' . $i, 'sectionID' => 'CDBM190 sec J03']);
        }
        for ($i = $studentsIdAddendNum; $i < $studentsIdNotInNum; $i++)
        {
            $this->notSeeInDatabase('StudentInCourseSection', ['userID' => 'Stu0' . $i, 'sectionID' => 'CDBM190 sec J03']);
        }
    }

    private function TestThreeOld18NewStudents()
    {
        $CSVIC = new CSVImportController();
        // set up Post so that they are attatched when functions are ran 
        $_POST['Section'] = 'J03';
        $_POST['Classes'] = 'CDBM190';

        $studentsIdAddstartNum = 60;
        $studentsIdAddendNum = 80;


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
        //#######################make this a loop##################
        for ($i = $studentsIdAddstartNum; $i <= $studentsIdAddendNum; $i++)
        {
            $this->seeInDatabase('Student', ['userID' => 'Stu0' . $i]);
        }
        // test to see that there are no mistakes of an extra user
        $this->notSeeInDatabase('Student', ['userID' => 'Stu081']);
        // check to see if all students are added to the course section table 
        for ($i = $studentsIdAddstartNum; $i < $studentsIdAddendNum; $i++)
        {
            $this->seeInDatabase('StudentInCourseSection', ['userID' => 'Stu0' . $i, 'sectionID' => 'CDBM190 sec J03']);
        }
        $this->notSeeInDatabase('StudentInCourseSection', ['userID' => 'Stu081', 'sectionID' => 'CDBM190 sec J03']);
    }

}
