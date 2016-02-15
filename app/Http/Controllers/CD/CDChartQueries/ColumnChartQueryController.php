<?php

namespace App\Http\Controllers\CD\CDChartQueries;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StudentActivity;

class ColumnChartQueryController extends Controller
{
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
    
    
    /**
     * Pupose: To see the total stress level.
     * 
     * @return $result - This is the query result.
     */
    public function totalAvgStressLevel()
    {
        //Average of stressLevel col.
        $queryTimeSpent = StudentActivity::avg('stressLevel');
        
        //Convert query objects to string array.
        $result = json_decode(json_encode($queryTimeSpent), true);
        
        return $result;
    }
}
