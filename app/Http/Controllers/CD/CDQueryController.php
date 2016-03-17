<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CD\ChartController;
use DB;
use App\Course;
use App\StudentActivity;
use App\Student;

/**
 * Purpose: This class will hold all of the queries that will be used by all of
 * the charts.
 */
class CDQueryController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Purpose: This will perform a query based on the courses and a parameter
     * specified on the chart form on the CD dashboard controller. The query
     * creates a average for the parameter and for one course.
     * 
     * @param type $courseToFind - Course that the averages will be calculated
     * for.
     * 
     * @param type $comparison - column with the values that will be averaged.
     * 
     * @return type - return a query object that is an average of all the values
     * associated with the column and course passed in.
     * 
     * @author Justin Lutzko & Sean Young
     * 
     * @date Feb 20 2016
     */
    public function queryTotalAvgByCourse($courseToFind, $comparison)
    {
        $comparison = $this->getTimeSpentandTimeEstiamtedColumns($comparison);
        
        //Perform the query.
        $queryResult = DB::table('StudentActivity')
            ->join('Activity', 'Activity.activityID', '=', 
                    'StudentActivity.activityID')
            ->join('Section', 'Section.sectionID', '=' , 'Activity.sectionID')
            ->join('Course', 'Course.courseID', '=', 'Section.courseID')
            ->select('StudentActivity.' . $comparison )
            ->where('Course.courseID', $courseToFind[0]['courseID'])
            ->avg($comparison);

        return $queryResult;
    }
    
    /**
     * Pupose: To see the total stress level.
     * 
     * @return $result - This is the query result.
     */
    public function totalAvgStressLevel()
    {
        //Average of stressLevel col.
        $queryTimeSpent = StudentActivity::avg('stressLevel');
        
        $queryResult = array('stressLevel' => $queryTimeSpent);
        
        //Convert query objects to string array.
        $result = json_decode(json_encode($queryResult), true);

        return $result;
    }
    
    public function queryTotalHoursSpentOnCourse($courseToFind, $comparison)
    {
        $comparison = $this->getTimeSpentandTimeEstiamtedColumns($comparison);
        
        //Perform the query.
        $queryResult = DB::table('StudentActivity')
            ->join('Activity', 'Activity.activityID', '=', 
                    'StudentActivity.activityID')
            ->join('Section', 'Section.sectionID', '=' , 'Activity.sectionID')
            ->join('Course', 'Course.courseID', '=', 'Section.courseID')
            ->select('StudentActivity.' . $comparison )
            ->where('Course.courseID', $courseToFind[0]['courseID'])
            ->sum($comparison);

        return $queryResult;
    }
    
    /**
     * Purpose: This function will return all of the courses as a JSON Object.
     * This will be used to create checkboxs for forms where all the courses
     * are needed.
     * 
     * @return JSON - array of all the courses.
     */
    public function getAllCourses()
    {
        //Get all of the courses from the DB using course model.
        $courses = Course::all();
        
        //Convert objects to string array.
        $result = json_decode(json_encode($courses), true);
        
        return $result;
    }
    
    /**
     * Purpose: This function will get all the students associated with each 
     * course passed in the courses array.
     * 
     * @param type $courses - array of courses.  
     * 
     * @return type - text array returned back contain course as the id and 
     * student array as the data.
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date March 17, 2015
     */
    public function getStudentsByCourse( $courses )
    {
        $result = array();
        
        //for each query perform the following.
        foreach( $course as $courses )
        {
            //perform query for student names.
            $queryResult = DB::table('Course')
                ->join('Section', 'Course.courseID', '=', 
                        'Section.courseID')
                ->join('Section', 'Section.sectionID', '=' , 'StudentSection.sectionID')
                ->join('StudentSection', 'StudentSection.userID', '=', 'Student.userID')
                ->select("(Student.fName + ' ' + Student.lName) as name" )
                ->where('Course.courseID', $course);
            
            //Assign the students to a course.
            $result[$course] = json_decode(json_encode($queryResult), true);
        }
        
        return $result;
    }
    
    /**
     * Purpose: This will get the default columns if nothing is selected.
     * 
     * @param type $comp - the paramter to be compared.
     * @return string return the proper colulmn name for the queries.
     */
    public function getTimeSpentandTimeEstiamtedColumns($comp )
    {
        if( $comp === 'spent' )
        {
            $comp = 'timeSpent';
        }
        
        if( $comp === 'estimated' )
        {
            $comp = 'timeEstimated';
        }
        
        return $comp;
    }
}
