<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CourseAssignmentController;
use App\Http\Controllers\CD\CSVImportController;
use Illuminate\Support\Facades\Artisan;

class S16Test extends TestCase
{
    /*
     * This will clear users/profs/students added in the test cases from the database
     */

use DatabaseTransactions;
  /**
     * Tests valid and invalid professor and student imports
     *
     * @return void
     */
    public function test()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
        $CSVIC = new CSVImportController();

        $CSVFolder = base_path() . '/tests/FilesForTesting/S16/';
        /* Here are we testing Succesful uploading of professors */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'Professors.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'professors.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals(' All 4 Professors added successfully.', $CSVIC->csvUploadProfessorsToDB());


        /* ProfessorsLengthError */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'Professors.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'professorsLengthError.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('email is larger than the acceptable size. (wow '
                . 'that description is way to long and will not be able to be '
                . 'inserted into the database and will give an error when you '
                . 'try to upload this file its not good good thing we build the '
                . 'site to be able to stop this from braking the website! At '
                . 'row 3)', $CSVIC->csvUploadProfessorsToDB());

        /* ProfessorsMissingHeader */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'ProfessorsMissingHeader.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'professorsMissingHeader.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('Header userID, not present in the Comma-Seperated'
                . ' values file(may be spelt wrong).', $CSVIC->csvUploadProfessorsToDB());

        /* ProfessorsMissing any Entries */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'ProfessorsNoEntires.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'ProfessorsNoEntires.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('There are no Entries in the CSV File', $CSVIC->csvUploadProfessorsToDB());

        /* ProfessorNotCSV File test */
        $_FILES = array('ProfessorsCSV' => [
                'name' => 'ProfessorsNotCSVFile.docx',
                'type' => 'application/vnd.openxmlformats-officedocument.'
                . 'wordprocessingml.document',
                'tmp_name' => $CSVFolder . 'ProfessorsNotCSVFile.docx',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('ProfessorsNotCSVFile.docx is not a Comma-'
                . 'Seperated values file.', $CSVIC->csvUploadProfessorsToDB());

        //======================================================================
        //              Students
        //======================================================================

        $_POST['Section'] = 'J03';

        $_POST['Classes'] = 'CDBM190';

        $sectionID = $CSVIC->createSectionForStudents();

        /* Testing Students Successful Upload */
        $_FILES = array('StudentsCSV' => [
                'name' => 'Students.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'students.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals(' All 9 Students added successfully to the Database.<br/> All 9 Students added successfully to CDBM190 sec J03.', 
                $CSVIC->csvUploadStudentToDB($sectionID));




        /* Testing Students Length Error */
        $_FILES = array('StudentsCSV' => [
                'name' => 'StudentsLenghtError.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'StudentsLenghtError.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('email is larger than the acceptable size. '
                . '(wow that description is way to long and will not be '
                . 'able to be inserted into the database and will give an '
                . 'error when you try to upload this file its not good good '
                . 'thing we build the site to be able to stop this from braking '
                . 'the website! At row 3)', $CSVIC->csvUploadStudentToDB($sectionID));

        /* Testing Students Missing Header */
        $_FILES = array('StudentsCSV' => [
                'name' => 'StudentsMissingHeader.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'StudentsMissingHeader.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('Header userID, not present in the Comma-Seperated'
                . ' values file(may be spelt wrong).', $CSVIC->csvUploadStudentToDB($sectionID));

        /* Testing Students Missing Required Rows */
        $_FILES = array('StudentsCSV' => [
                'name' => 'StudentsMissingRequiredRows.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'StudentsMissingRequiredRows.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('userID is required but is empty at row 2', $CSVIC->csvUploadStudentToDB($sectionID));

        /* Students Not CSV File */
        $_FILES = array('StudentsCSV' => [
                'name' => 'StudentsNotCSVFile.docx',
                'type' => 'application/vnd.openxmlformats-officedocument.'
                . 'wordprocessingml.document',
                'tmp_name' => $CSVFolder . 'StudentsNotCSVFile.docx',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('StudentsNotCSVFile.docx is not a Comma-Seperated '
                . 'values file.', $CSVIC->csvUploadStudentToDB($sectionID));


        /* Testing Students Missing Required Rows */
        $_FILES = array('StudentsCSV' => [
                'name' => 'StudentsNoEntries.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'StudentsNoEntries.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('There are no Entries in the CSV File', $CSVIC->csvUploadStudentToDB($sectionID));
    }

}
