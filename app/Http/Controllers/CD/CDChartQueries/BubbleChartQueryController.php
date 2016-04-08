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
class BubbleChartQueryController extends CDQueryController {

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
    public function allCoursesComparison($comparison1, $comparison2) {
        //Get all of the courses from the DB using course model.
        $courses = Course::all();

        //Create a stats array.
        $stats = array();

        //Loop through each course.
        foreach ($courses as $course) {
            //make stats an associative array with the courseID being the
            //id. The value will contain an avg., avg., and total time spent on
            //the course.
            $stats[$course->courseID] = $this->avgComparisonForCourseWithTotals($comparison1, $comparison2, $course->courseID);
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
    public function avgComparisonForCourseWithTotals($comparison1, $comparison2, $course) {
        $comparison1 = $this->getTimeSpentandTimeEstimatedColumns($comparison1);
        $comparison2 = $this->getTimeSpentandTimeEstimatedColumns($comparison2);

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
        $queryResult = array('param1' => $queryComp1,
            'param2' => $queryComp2, 'courseID' => $course,
            'totalHours' => $queryTotalSumForCourse);

        //Convert objects to associative string array.
        $result = json_decode(json_encode($queryResult), true);

        return $result;
    }

    /**
     * Purpose: This function will query three parameter for the bubble chart.
     * The first two comparisons will be averages of the first two parameters
     * passed in and the third parameters will be the total amount of time 
     * spent on a course (or time estimate or stresslevel).
     * 
     * @param String $comparison1 - comparason1 will be the first comparison.
     * will be an average.
     *  
     * @param String $comparison2 - second parameter to compare. Will be an 
     * average.
     * 
     * @param String $comparison3 - will be the total amount of time or stress
     * spent by a group of students on a course.
     * 
     * @param String[] $courses - List of courses that will be used to obtain 
     * data.
     * courses that the students are in.
     * 
     * @param String[] $studentAndCourse - List of student to perform query on.
     * 
     * @return String[][] $allAverages - All stats of the students.
     * 
     * @author Mark & Justin
     * 
     * @date March 28, 2016
     */
    public function findTotalsBasedStudentsInCourse($comparison1, $comparison2, $comparison3, $courses, $studentAndCourse) {

        $allAverages = array();

        $comparison1 = $this->getTimeSpentandTimeEstimatedColumns($comparison1);
        $comparison2 = $this->getTimeSpentandTimeEstimatedColumns($comparison2);
        $comparison3 = $this->getTimeSpentandTimeEstimatedColumns($comparison3);



        foreach ($studentAndCourse as $indCourse => $studentCourse) {
            $totalComparison1 = 0;
            $totalComparison2 = 0;
            $totalComparison3 = 0;
            $countComparison1 = 0;
            $countComparison2 = 0;
            $countComparison3 = 0;
            
            $avgComparison1 = 0;
            $avgComparison2 = 0;
            $avgComparison3 =0;
            
            foreach ($studentCourse as $indStudent) {

                $qurResult1 = $this->queryOnCourseIndStudent($indCourse, $comparison1, $indStudent);

                if ($qurResult1 != null) {
                    $totalComparison1 += $qurResult1[0][$comparison1];
                    $countComparison1++;
                }

                $qurResult2 = $this->queryOnCourseIndStudent($indCourse, $comparison2, $indStudent);

                if ($qurResult2 != null) {
                    $totalComparison2 += $qurResult2[0][$comparison2];
                    $countComparison2++;
                }

                $qurResult3 = $this->queryOnCourseIndStudent($indCourse, $comparison3, $indStudent);

                if ($qurResult3 != null) {
                    $totalComparison3 += $qurResult3[0][$comparison3];
                    $countComparison3++;
                }
            }
            
            if( $countComparison1 != 0 )
            {
                $avgComparison1 = $totalComparison1 / $countComparison1;
            }
            
            if( $countComparison1 != 0 )
            {
                $avgComparison2 = $totalComparison2 / $countComparison2;
            }
            
            if( $countComparison1 != 0 )
            {
                 $avgComparison3 = $totalComparison3 / $countComparison3;
            }

            $allAverages[$indCourse] = array("courseID" => $indCourse, "param1" => $avgComparison1,
                "param2" => $avgComparison2, "param3" => $avgComparison3, "courseID" => $indCourse);
        }
        //}
        //}
        return $allAverages;
    }

}
