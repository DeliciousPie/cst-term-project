<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CSVImportController;
use Illuminate\Support\Facades\Artisan;

class S08Test extends TestCase
{

    use DatabaseTransactions;
    /*
     * This will clear courses added in the test cases from the database
     */

    public function clearDB()
    {
        DB::delete('delete from Course where courseID = "MEDC 100.0" OR '
                . 'courseID = "MEDC 101.0" OR courseID = "MEDC 111.0"');
    }

    /**
     * Tests valid and invalid course imports
     *
     * @return void
     */
    public function testCourses()
    {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed'); 

        $this->clearDB();

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

        $this->assertEquals(' All 7 courses added successfully.', $CAC->csvUploadCoursesToDB());
        $this->clearDB();

        /* Course Length Error */
        $_FILES = array('CourseCSV' => [
                'name' => 'coursesLengthError.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'coursesLengthError.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('description is larger than the acceptable size. '
                . '(wow that description is way to long and will not be able '
                . 'to be inserted into the database and will give an error '
                . 'when you try to upload this file its not good good thing '
                . 'we build the site to be able to stop this from braking the '
                . 'website! At row 4)', $CAC->csvUploadCoursesToDB());
        $this->clearDB();

        /* Testing coursesMissingRequiredRows.csv */
        $_FILES = array('CourseCSV' => [
                'name' => 'coursesMissingRequiredRows.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'coursesMissingRequiredRows.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('courseID is required but is empty at row 3', $CAC->csvUploadCoursesToDB());
        $this->clearDB();

        /* Testing coursesWrongHeader.csv */
        $_FILES = array('CourseCSV' => [
                'name' => 'coursesWrongHeader.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'coursesWrongHeader.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('Header courseID, not present in the Comma-Seperated'
                . ' values file(may be spelt wrong).', $CAC->csvUploadCoursesToDB());
        $this->clearDB();

        /* Testing coursesWrongHeader.csv */
        $_FILES = array('CourseCSV' => [
                'name' => 'NotACSVFile.docx',
                'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'tmp_name' => $CSVFolder . 'NotACSVFile.docx',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('NotACSVFile.docx is not a Comma-Seperated '
                . 'values file.', $CAC->csvUploadCoursesToDB());
        $this->clearDB();


        /* Testing coursesWrongHeader.csv */
        $_FILES = array('CourseCSV' => [
                'name' => 'coursesNoEntries.csv',
                'type' => 'application/vnd.ms-excel',
                'tmp_name' => $CSVFolder . 'coursesNoEntries.csv',
                'error' => 0,
                'size' => 173
        ]);

        $this->assertEquals('There are no Entries in the CSV File'
                , $CAC->csvUploadCoursesToDB());
        $this->clearDB();
    }

}
