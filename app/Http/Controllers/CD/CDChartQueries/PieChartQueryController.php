<?php

namespace App\Http\Controllers\CD\CDChartQueries;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StudentActivity;
use DB;
class PieChartQueryController extends Controller
{
    public function findTimeSpentOnCourse()
    {

        $queryResult = DB::table('StudentActivity')
                ->join('Activity', 'Activity.activityID', '=', 'StudentActivity.activityID')
                ->join('Section', 'Section.sectionID', '=' , 'Activity.sectionID')
                ->join('Course', 'Course.courseID', '=', 'Section.courseID')
                ->select( DB::raw('avg(StudentActivity.timeSpent)as \'Time Spent\', Course.courseID as Course'))
                ->groupBy('Course.courseID')
                ->get();
     
        $allCourses = json_decode(json_encode($queryResult), true);
        
        return $allCourses;
        
    }
}
