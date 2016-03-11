<?php

namespace App\Http\Controllers\CD\CDChartQueries;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ChartManagerController;
use App\Http\Controllers\CD\CDQueryController;
use App\Course;

/**
 * Purpose: Hold queries that are specific to bubble charts.
 */
class BubbleChartQueryController extends CDQueryController
{
    //Constant that will be the timeSpent value on the CD Dashboard selection
    //form.
    const SPENT = "spent";
    
    /**
     * Purpose: This function will allow us to get the total time spent on a 
     * class, the avg time estimated for a class, the avg time estimated 
     * for a  class or the avg stress level for a class. Any variation of the 
     * three avgerages can be used but only two averages will be used for 
     * comparison.
     * 
     * This function relies heavily on the avgComparisonForCourseWithTotals 
     * function.
     * 
     * @param type $comparison1 - Time Spent, Time Estimated, Stress Level from
     * the chart selection form on the CD Dashboard.
     * 
     * @param type $comparison2 - Time Spent, Time Estimated, Stress Level from
     * the chart selection form on the CD Dashboard.
     * 
     * @return type - Return the data obtained from this query.
     * 
     * @author Justin Lutzko
     * 
     * @date March 10, 2016
     */
    public function allCoursesComparison($comparison1, $comparison2)
    {
        //Get all of the courses from the DB using course model.
        $courses = Course::all();
        
        //Create a stats array.
        $stats = array();
        
        //Loop through each course.
        foreach($courses as $course) 
        {
            //make stats an associative array with the courseID being the
            //id. The value will contain an avg., avg., and total time spent on
            //the course.
            $stats[$course->courseID] = 
                    $this->avgComparisonForCourseWithTotals($comparison1, 
                    $comparison2, $course->courseID);
        }
        
        return $stats;
    }
    
    
    
    /**
     * Purpose: This will perform average calculations and total calculations
     * for the columns specified
     * by the comparison parameters that are specified in the chart from on the 
     * CD dashboard page.  This will use a course parameter to selected the data
     * for courses.
     * 
     * @param type $comparison1 - parameter1 from CD dashboard page. (Stress,
     * timeEstimated, timeSpent).
     * 
     * @param type $comparison2 - parameter2 from CD dashboard page. (Stress,
     * timeEstimated, timeSpent).
     * 
     * @param type $course - This is the courseID from the course table in the 
     * DB. This is passed in from the chart form on the CD dashboard form.
     * 
     * @return type - return a query string with total averages for the 
     * specified columns and for the specified course.
     * 
     * @author Justin Lutzko & Sean Young 
     * 
     * @date Feb 20, 2016
     */
    public function avgComparisonForCourseWithTotals($comparison1, $comparison2, 
            $course)
    {
        $comparison1 = $this->getTimeSpentandTimeEstiamtedColumns($comparison1);
        $comparison2 = $this->getTimeSpentandTimeEstiamtedColumns($comparison2);
        
        //Find course DB passed in from the form.  Changes from what user passes
        //in to what the database has.
        $courseToFind = Course::select('courseID')
                ->where('courseID', $course)
                ->get();
        
        //Change from query object to associative string array.
        $courseToFind = json_decode(json_encode($courseToFind), true);
        
        
        
        //Query based on first parameter and course. Becomes query object.
        $queryComp1 = $this->queryTotalAvgByCourse($courseToFind, $comparison1);
        
        //Query based on second parameter and course. Becomes query object.
        $queryComp2 = $this->queryTotalAvgByCourse($courseToFind, $comparison2);
        
        $queryTotalSumForCourse = $this->queryTotalHoursSpentOnCourse($courseToFind, self::SPENT);
        
        //link both query object into same array.
        $queryResult = array( 'param1'=> $queryComp1, 
            'param2' => $queryComp2, 'courseID' => $course,
            'totalHours' => $queryTotalSumForCourse);
     
        //Convert objects to associative string array.
        $result = json_decode(json_encode($queryResult), true);
        
        return $result;      
    }
    

}
