<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CD\ChartController;
use DB;
use App\StudentActivity;
/**
 * Purpose: This class will hold all of the queries that will be used by all of
 * the charts.
 */
abstract class CDQueryController extends ChartController
{
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
    
}
