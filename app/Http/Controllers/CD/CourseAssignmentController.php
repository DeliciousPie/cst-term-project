<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Course;
use App\Professor;
use App\Student;

/*
 * This controler is designed to help display the 
 * course Assignment blade  to allow the CD to import 
 * corses, proffesors and students  
 */

class CourseAssignmentController extends Controller
{

    //Constructor for CourseAssignmentController
    public function _construct()
    {
        $this->middleware('cdmanager');
    }

    /*
     * LoadView queries the database for courses, students and professors.
     * It puts each group into an array.
     * Returns the three arrays back to the view
     */

    public function LoadView()
    {
        $classes = [];
        $students = [];
        $professors = [];

        //Select all courses from Course
        $courses = DB::select('SELECT courseID FROM Course');
        for ($i = 0; $i < count($courses); $i++)// need to get this to work dinam.. 
        {
            array_push($classes, $courses[$i]->courseID);
        }

        //Select all courses from Student
        $stuFromDB = DB::select('SELECT fName,lName FROM Student');
        for ($i = 0; $i < count($stuFromDB); $i++)
        {
            array_push($students, $stuFromDB[$i]->fName);
        }

        //Select all courses from Professor
        $profFromDB = DB::select('SELECT fName,lName FROM Professor');
        for ($i = 0; $i < count($profFromDB); $i++)
        {
            array_push($professors, $profFromDB[$i]->fName);
        }

        //Return a view with a link to the view and arrays
        return view('CD/CourseAssignmentMain', compact('classes', 'students', 'professors'));
    }

    /*
     * Upload CSV files will upload any CSV files.
     * It willl
     */

    public function uploadCSVFiles()
    {
        set_time_limit(10000);

        $_POST['courseMessage'] = $this->csvUploadCoursesToDB();

        $_POST['professorsMessage'] = $this->csvUploadProfessorsToDB();

        $_POST['studentsMessage'] = $this->csvUploadStudentToDB();
        //******ended here**********************************
        //need to modify this to reflect professor and do again for students

        set_time_limit(30);

        //Select all courses from Course
        $courses = DB::select('SELECT courseID FROM Course');
        $classes = [];
        for ($i = 0; $i < count($courses); $i++)// need to get this to work dinam.. 
        {
            array_push($classes, $courses[$i]->courseID);
        }

        //Select all courses from students
        $students = [];
        $stuFromDB = DB::select('SELECT fName,lName FROM Student');
        for ($i = 0; $i < count($stuFromDB); $i++)
        {
            array_push($students, $stuFromDB[$i]->fName);
        }


        //Select all courses from Professor
        $professors = [];
        $profFromDB = DB::select('SELECT fName,lName FROM Professor');
        for ($i = 0; $i < count($profFromDB); $i++)
        {
            array_push($professors, $profFromDB[$i]->fName);
        }
        //Return the view and compact arrays
        $_FILES = array();
        return view('CD/CourseAssignmentMain', compact('classes', 'students', 'professors'));
    }

    /*
     * This will check if a file is CSV and return the data from it
     * Returns an error or an associative array of data
     */

    private function csv_to_array($file, $delimiter = ',')
    {
        if (!is_readable($file['tmp_name']))
        {
            return FALSE;
        }

        //Only accept these types
        $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
        if (in_array($file['type'], $mimes))
        {
            $header = NULL;
            $headerSize = 0;
            $data = array();
            if (($handle = fopen($file['tmp_name'], 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    if (!$header)
                    {
                        $header = $row;
                        $headerSize = count($header);
                    } else
                    {
                        if ($headerSize == count($row))
                        {
                            $data[] = array_combine($header, $row);
                        } else
                        {
                            $data['error'] = $file['name'] .
                                    " The header count does not match the amount"
                                    . " of columns in the Comma-Seperated values file.";
                            return $data;
                        }
                    }
                }
                fclose($handle);
            }
            return $data;
        } else // It is not CSV
        {
            $data['error'] = $file['name'] . " is not a Comma-Seperated values file.";
            return $data;
        }
    }

    /*
     * Will check and if valid upload courses to the DB.
     * returns a string description of the result
     */

    public function csvUploadCoursesToDB()
    {
        $resultString = 'No course file csv file selected.';
        //Check if the file is ok
        if (($_FILES['CourseCSV']['error'] == UPLOAD_ERR_OK))
        {
            $resultString = '';
            $totalCoursesChecked = 0;
            $classesAdded = 0;
            $existingCourses = 'Courses ';

            $courseCSVFile = $_FILES['CourseCSV'];


            //gets csv file and converts into array to be used by php 
            $coursesArray = $this->csv_to_array($courseCSVFile);

            //validate the CSV file 
            $errorMessage = $this->ValidateCSVWithDataBase('Course', $coursesArray);
            //Error message will be true if there was no error a string if there
            //was an error
            if (is_string($errorMessage))
            {
                $coursesArray['error'] = $errorMessage;
            }

            //Check if an error exists
            if (isset($coursesArray['error']))
            {
                $resultString = $coursesArray['error'];
            } else
            {

                /// can be added to 
                foreach ($coursesArray as $currentCourse)
                { // error checks that the manditory fields are entered in the CSV
                    $totalCoursesChecked++;
                    $dbSelectVar = DB::select('SELECT courseID, courseName, description FROM Course WHERE courseID = ?', array($currentCourse['courseID']));

                    if (!$dbSelectVar)
                    {
                        // uses modle to create new Course 
                        Course::create([
                            'courseID' => $currentCourse['courseID'],
                            'courseName' => $currentCourse['courseName'],
                            'description' => $currentCourse['description']
                        ]);
                        $classesAdded++;
                    } else
                    {
                        $existingCourses .= $currentCourse['courseID'] . ", ";
                    }
                }
                $existingCourses = rtrim($existingCourses, ', ');
                $existingCourses .= ' already existed.';

                if ($classesAdded < $totalCoursesChecked)
                {
                    $resultString = $classesAdded . "/" . $totalCoursesChecked .
                            " added sucessfully. " . $existingCourses;
                } else //if($classesAdded === $totalCoursesChecked)
                {
                    $resultString = " All " . $totalCoursesChecked . ' courses added sucessfully.';
                }
            }
        }
        return $resultString;
    }

    /*
     * Will check and if valid upload profs to the DB.
     * returns a string description of the result
     */

    public function csvUploadProfessorsToDB()
    {
        $resultString = 'No professor file csv file selected';
        //Check if file uploaded ok
        if ($_FILES['ProfessorsCSV']['error'] == UPLOAD_ERR_OK)
        {
            $resultString = '';
            $totalProfessorsChecked = 0;
            $professorsAdded = 0;
            $existingProfessors = 'Professors ';

            //Get handle to file
            $ProfessorCSVFile = $_FILES['ProfessorsCSV'];

            //gets csv file and converts into array to be used by php 
            $professorArray = $this->csv_to_array($ProfessorCSVFile);

            $errorMessage = $this->ValidateCSVWithDataBase('Professor', $professorArray);
            //Error message will be true if there was no error a string if there
            //was an error
            if (is_string($errorMessage))
            {
                $professorArray['error'] = $errorMessage;
            }
            //Check for an error
            if (isset($professorArray['error']))
            {
                $resultString = $professorArray['error'];
            } else
            {
                //For every professor
                foreach ($professorArray as $currentProfessor)
                {
                    $totalProfessorsChecked++;
                    $userSelectVar = DB::select('SELECT userID FROM users WHERE userID = ?', array($currentProfessor['userID']));
                    $dbSelectVar = DB::select('SELECT userID FROM Professor WHERE userID = ?', array($currentProfessor['userID']));

                    //Check if user already exists
                    if (!$dbSelectVar && !$userSelectVar)
                    {
                        //Create a new user and professor
                        $professorsAdded++;
                        $generatedPassword = 'password';

                        // uses modles to create new user 
                        User::create([
                            'userID' => $currentProfessor['userID'],
                            'name' => $currentProfessor['fName'],
                            'password' => bcrypt($generatedPassword),
                            'email' => $currentProfessor['email'],
                        ]);
                        // uses modles to create new Professor
                        Professor::create([
                            'userID' => $currentProfessor['userID'],
                            'fName' => $currentProfessor['fName'],
                            'lName' => $currentProfessor['lName'],
                            'educationalInstitution' => $currentProfessor['educationalInstitution'],
                            'email' => $currentProfessor['email']
                        ]);
                    } else
                    {
                        $existingProfessors .= $currentProfessor['userID'] . ", ";
                    }
                }
                $existingProfessors = rtrim($existingProfessors, ', ');
                $existingProfessors .= ' already existed.';

                //If some of the imports already existed
                if ($professorsAdded < $totalProfessorsChecked)
                {
                    $resultString = $professorsAdded . "/" . $totalProfessorsChecked .
                            " added sucessfully. " . $existingProfessors;
                } else //all imports were successful
                {
                    $resultString = " All " . $totalProfessorsChecked . ' Professors added sucessfully.';
                }
            }
        }
        return $resultString;
    }

    /*
     * Will check and if valid upload students to the DB.
     * returns a string description of the result
     */

    public function csvUploadStudentToDB()
    {
        $resultString = 'No student file csv file selected';
        //Check if the file uploaded
        if ($_FILES['StudentsCSV']['error'] == UPLOAD_ERR_OK)
        {
            $resultString = '';
            $totalStudentsChecked = 0;
            $studentsAdded = 0;
            $existingStudents = 'Students ';

            $StudentsCSVFile = $_FILES['StudentsCSV'];

            //gets csv file and converts into array to be used by php 
            $studentsArray = $this->csv_to_array($StudentsCSVFile);

            $errorMessage = $this->ValidateCSVWithDataBase('Student', $studentsArray);
            //Error message will be true if there was no error a string if there
            //was an error
            if (is_string($errorMessage))
            {
                $studentsArray['error'] = $errorMessage;
            }

            if (isset($studentsArray['error']))
            {
                $resultString = $studentsArray['error'];
            } else
            {
                //For every professor
                foreach ($studentsArray as $currentStudent)
                {
                    $totalStudentsChecked++;
                    $userSelectVar = DB::select('SELECT userID FROM users WHERE userID = ?', array($currentStudent['userID']));
                    $dbSelectVar = DB::select('SELECT userID FROM Student WHERE userID = ?', array($currentStudent['userID']));

                    //Check if user already exists
                    if (!$dbSelectVar && !$userSelectVar)
                    {

                        $generatedPassword = 'password';

                        // uses Modles to add new user to DB 
                        User::create([
                            'userID' => $currentStudent['userID'],
                            'name' => $currentStudent['fName'],
                            'password' => bcrypt($generatedPassword),
                            'email' => $currentStudent['email'],
                        ]);

                        // uses Modles to add new Student 
                        Student::create([
                            'userID' => $currentStudent['userID'],
                            'age' => $currentStudent['age'],
                            'areaOfStudy' => $currentStudent['areaOfStudy'],
                            'fName' => $currentStudent['fName'],
                            'lName' => $currentStudent['lName'],
                            'educationalInstitution' => $currentStudent['educationalInstitution'],
                            'email' => $currentStudent['email']
                        ]);
                        $studentsAdded++;
                    } else // user exists already
                    {
                        $existingStudents .= $currentStudent['userID'] . ", ";
                    }
                }
                $existingStudents = rtrim($existingStudents, ', ');
                $existingStudents .= ' already existed.';

                //Some of the imports already existed
                if ($studentsAdded < $totalStudentsChecked)
                {
                    $resultString = $studentsAdded . "/" . $totalStudentsChecked .
                            " added sucessfully. " . $existingStudents;
                } else //all imports successful
                {
                    $resultString = " All " . $totalStudentsChecked . ' Students added sucessfully.';
                }
            }
        }
        return $resultString;
    }

    //This compares the field names, data lengths, data types, null values
    //between the CSV and DB.
    protected function ValidateCSVWithDataBase($tableName, $CSVArray)
    {
        //Check the value lengthd make sure fits into database
        $columns = DB::select('show Columns from ' . $tableName);

        //Check if an error exists
        if (!isset($CSVArray['error']))
        {
            $headers = '';
            $headerNotValid = false;
            //This foreach will validate the headers with what the database
            //has.
            foreach ($columns as $eachColumn)
            {
                $dbFieldName = $eachColumn->Field;

                // check to see if there is any entries in the file 
                if (!isset($CSVArray[0]))
                {
                    return "There are no Entries in the CSV File";
                }
                //Check if the CSV file has a header which matches the DB's
                if (!isset($CSVArray[0][$dbFieldName]))
                {
                    //Add failing flag
                    $headerNotValid = true;
                    $headers .= $dbFieldName . ', ';
                }
            }

            //check if header invalid
            if ($headerNotValid)
            {
                return "Header " . $headers . "not present in the Comma-Seperated values file(may be spelt wrong).";
            }

            $currentRow = 0;
            //For every row in the CSV file
            foreach ($CSVArray as $row)
            {
                //there are no header errors, check for mandatory values.
                //Verify the data
                foreach ($columns as $eachColumn)
                {
                    //Check the field value, if it is required
                    $dbFieldName = $eachColumn->Field;
                    $canBeNull = $eachColumn->Null == 'YES';
                    
                    if (!($dbFieldName == 'id')&& 
                        !($dbFieldName == 'created_at')&&
                        !($dbFieldName == 'updated_at') )
                    {
                        if (!$canBeNull)
                        {
                            if ($CSVArray[$currentRow][$dbFieldName] == '')
                            {
                                return $dbFieldName . " is required but is empty at row " . ($currentRow + 2);
                            }
                        }
                

                    $resultingMatches = array();
                    
                    //Check the field type, make sure it matches DB
                    $matched = preg_match( '/^[A-Za-z0-9]+\(([0-9]+)\)$/', $eachColumn->Type, $resultingMatches );
                    
                    $DBValueType = $resultingMatches[1];
                    
                        //This flag will be set if it is a character and the size
                        //Must match the max size.
                        $forceMaxSize = false;
                        //Check if it is an integer, do extra validation
                        if ($DBValueType == 'int')
                        {
                            if (!is_int($CSVArray[$currentRow][$dbFieldName]))
                            {
                                return $dbFieldName . " should be an whole number. but is " . $CSVArray[$currentRow][$dbFieldName] . " At row " . ($currentRow + 2);
                            }
                        } elseif ($DBValueType == 'char')
                        {
                            //This flag will be set if it is a character and the size
                            //Must match the max size.
                            $forceMaxSize = true;
                        }

                        //Check the field length, make sure its within allowed size
                        //Pass in an array, preg_match will put the result in the array
                        $resultingMatches = array();

                        //Check the field type, make sure it matches DB
                        $matched = preg_match('/^[A-Za-z0-9]+\(([0-9]+)\)$/', $eachColumn->Type, $resultingMatches);

                        $size = $resultingMatches[1];

                        $resultingMatches = array();
                        //Get the size of the CSV value

                        $minLength = 0;
                        $maxLength = $size;

                        //If the minimum size is the max size (CHAR)
                        if ($forceMaxSize)
                        {
                            $minLength = $maxLength;
                        }

                        //Checks that the CSV value is within the acceptable DB length
                        $matched = preg_match('/^([\s\S]{' . $minLength . ',' .
                                $maxLength . '})$/', $CSVArray[$currentRow][$dbFieldName], $resultingMatches);

                        if (!$matched)
                        {
                            return $dbFieldName . " is larger than the acceptable size. (" . $CSVArray[$currentRow][$dbFieldName] . " At row " . ($currentRow + 2) . ')';
                        }
                    }
                }
                
                $currentRow++;
            }
        }
        //Validation succesful.
        return true;
    }

}
