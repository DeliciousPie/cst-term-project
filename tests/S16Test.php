<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CourseAssignmentController; 
use App\Professor;

class S16Test extends TestCase
{
    
  
  /*
     * This will clear users/profs/students added in the test cases from the database
     */
    public function clearDB()
    {
        
        DB::delete('delete from users where userID = "Pro001" OR userID = '
                . '"Pro002" OR userID = "Stu001" OR userID = "Stu002"');
                
        DB::delete('delete from Professor where userID = "Pro001" OR userID = '
                . '"Pro002"');
        
        DB::delete('delete from Student where userID ="Stu001" OR userID = '
                . '"Stu002"');
        
        $allProf = Professor::all();
        
//        DB::table('Professor')->delete();
//        
//        foreach( $allProf as $Prof )
//        {
//            DB::table('users')
//                ->where('userID', '=', $Prof->userID )
//                ->delete();
//        }
        
        
    }

    /**
     * Tests valid and invalid professor and student imports
     *
     * @return void
     */
    public function test()
    {
        $this->clearDB();
        
        $CAC = new CourseAssignmentController(); 
        
        $CSVFolder = base_path() . '/tests/FilesForTesting/S16/';
            
        /*Here are we testing Succesful uploading of professors */
        $_FILES = array('ProfessorsCSV' => [
            'name' => 'Professors.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'professors.csv',
            'error' => 0,
            'size' => 173
        ]);
        
        $this->assertEquals('0/4 added sucessfully. Professors Pro010, Pro011, Pro012, '
                . 'Pro013 already existed.', 
                $CAC->csvUploadProfessorsToDB());      
        $this->clearDB();
        
        
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
            . 'row 3)', $CAC->csvUploadProfessorsToDB()); 
        $this->clearDB();
        
        /* ProfessorsMissingHeader */
        $_FILES = array('ProfessorsCSV' => [
            'name' => 'ProfessorsMissingHeader.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'professorsMissingHeader.csv',
            'error' => 0,
            'size' => 173
        ]);
        
        $this->assertEquals('Header userID, not present in the Comma-Seperated'
                . ' values file(may be spelt wrong).', 
            $CAC->csvUploadProfessorsToDB()); 
        $this->clearDB();
        
                /* ProfessorsMissing any Entries */
        $_FILES = array('ProfessorsCSV' => [
            'name' => 'ProfessorsNoEntires.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'ProfessorsNoEntires.csv',
            'error' => 0,
            'size' => 173
        ]);
        
        $this->assertEquals('There are no Entries in the CSV File', 
            $CAC->csvUploadProfessorsToDB()); 
        $this->clearDB();
        
        
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
                . 'Seperated values file.', 
            $CAC->csvUploadProfessorsToDB());
        $this->clearDB();
        
        
        
        
        //======================================================================
        //              Students
        //======================================================================
                /* Testing Students Successful Upload */
        $_FILES = array('StudentsCSV' => [
            'name' => 'Students.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'students.csv',
            'error' => 0,
            'size' => 173
        ]);

        $this->assertEquals('2/9 added sucessfully. Students Stu003, Stu004, '
                . 'Stu005, Stu006, Stu007, Stu008, Stu009 already existed.', 
                $CAC->csvUploadStudentToDB());
        $this->clearDB();
        
        
        
        
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
            . 'the website! At row 3)', $CAC->csvUploadStudentToDB());
        $this->clearDB();
        
        /* Testing Students Missing Header */
        $_FILES = array('StudentsCSV' => [
            'name' => 'StudentsMissingHeader.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'StudentsMissingHeader.csv',
            'error' => 0,
            'size' => 173
        ]);

        $this->assertEquals('Header userID, not present in the Comma-Seperated'
                . ' values file(may be spelt wrong).', 
                $CAC->csvUploadStudentToDB());
        $this->clearDB();
        
        /* Testing Students Missing Required Rows */
        $_FILES = array('StudentsCSV' => [
            'name' => 'StudentsMissingRequiredRows.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'StudentsMissingRequiredRows.csv',
            'error' => 0,
            'size' => 173
        ]);

        $this->assertEquals('userID is required but is empty at row 2', 
                $CAC->csvUploadStudentToDB());
        $this->clearDB();
        
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
                . 'values file.', 
            $CAC->csvUploadStudentToDB());
        $this->clearDB();
    

            /* Testing Students Missing Required Rows */
        $_FILES = array('StudentsCSV' => [
            'name' => 'StudentsNoEntries.csv',
            'type' => 'application/vnd.ms-excel',
            'tmp_name' => $CSVFolder . 'StudentsNoEntries.csv',
            'error' => 0,
            'size' => 173
        ]);

        $this->assertEquals('There are no Entries in the CSV File', 
                $CAC->csvUploadStudentToDB());
        $this->clearDB();
        
    }
}
