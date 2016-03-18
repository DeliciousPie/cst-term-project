<?php

namespace App\Http\Controllers\CD\CDChartQueries;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StudentActivity;
use App\Course;
use DB;
use App\Http\Controllers\CD\CDQueryController;
/**
 * Purpose: The purpose of this controller to perform queries for the Column
 * chart.  It is import to note the the ColumnChartController inherits from this
 * class.  
 * 
 * @author Justin Lutzko & Sean Young 
 * 
 * @date Feb 20 2016
 * 
 */
class ColumnChartQueryController extends CDQueryController
{
    
    /**
     * Purpose: This query will perfrom average queries based on the parameters
     * passed in from the CD Dashboard pages.  This query however does not take
     * into account classes or anyother parameters.
     * 
     * @param type $comparison1 - parameter1 from CD dashboard page. (Stress,
     * timeEstimated, timeSpent).
     * 
     * @param type $comparison2- parameter2 from CD dashboard page. (Stress,
     * timeEstimated, timeSpent).
     * 
     * @return type - will return a associative string array.
     * 
     * @author Justin Lutzko & Sean Young 
     * 
     * @date Feb 20, 2016
     */
    public function performAvgComparisonQuery($comparison1, $comparison2)
    {
        $comparison1 = $this->getTimeSpentandTimeEstimatedColumns($comparison1);
        $comparison2 = $this->getTimeSpentandTimeEstimatedColumns($comparison2);
        //perform query on all of the value for comparison1 from the 
        //Student activity table in the DB. Specified on chart form in CD
        //dashboard.
        $queryComp1 = StudentActivity::avg($comparison1);
        
        //perform query on all of the value for comparison2 from the 
        //Student activity table in the DB.
        $queryComp2 = StudentActivity::avg($comparison2);
        
        //link both query object into same array.
        $queryResult = array( 'param1'=> $queryComp1, 
            'param2' => $queryComp2);
      
        //Convert objects to string array.
        $result = json_decode(json_encode($queryResult), true);
        
        //Return.
        return $result;
    }
    
    /**
     * Purpose: This will perform average calculations for the columns specified
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
    public function performAvgComparisonForCourse($comparison1, $comparison2, 
            $course)
    {
        $comparison1 = $this->getTimeSpentandTimeEstimatedColumns($comparison1);
        $comparison2 = $this->getTimeSpentandTimeEstimatedColumns($comparison2);
        //Find from DB passed in from the form.  Changes from what user passes
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
        
        //link both query object into same array.
        $queryResult = array( 'param1'=> $queryComp1, 
            'param2' => $queryComp2);
     
        //Convert objects to associative string array.
        $result = json_decode(json_encode($queryResult), true);
        
        return $result;      
    }
    

    
    //public function performAvgComparisonQueryForClass
    /**
     * Purpose: This method will grab the avg of all the values in the timespent
     * column from the student activies chart and the timeEstimated column.
     * This data will be used to see how close student estimates were to there 
     * actual results.
     * 
     * @return $result - This is an associative array of the data.  The columns
     * are the keys.
     */
    public function avgTimeEstVsAvgTimeSpent()
    {
        //Average of timeSpent col.
        $queryTimeSpent = StudentActivity::avg('timeSpent');
        
        //Average of timeEstimated col.
        $queryTimeEstimated = StudentActivity::avg('timeEstimated');
      
        //link both query object into same array.
        $queryResult = array( 'timeSpent'=> $queryTimeSpent, 
            'timeEstimated' => $queryTimeEstimated);
      
        //Convert objects to string array.
        $result = json_decode(json_encode($queryResult), true);
        
        return $result;
    }
    
    

}
