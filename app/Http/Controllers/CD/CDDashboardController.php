<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use App\Http\Controllers\CD\CDChartQueries\ColumnChartQueryController;
use App\Http\Controllers\CD\CDCharts\ColumnChartController;
use App\Http\Controllers\CD\CDChartQueries\PieChartQueryController;

class CDDashboardController extends Controller
{
    /**
     * Purpose: This will create a standard dashboard for the CD.
     * 
     * @return return a dashboard and some standard charts.
     */
    public function createDefaultDashboard() 
    {

        //Create controller to create chart.
        $queryColumnChartController = new ColumnChartQueryController();
        $chartColumnTimeChart = new ColumnChartController();
        
        //Query the total avg. timeSpent and timeEstimated.
        $avgTimeEstVsActualTimeQuery = $queryColumnChartController
                ->avgTimeEstVsAvgTimeSpent();
        
        //Use query to build column chart.
        $avgTimeEstVsActualTimeChart = $chartColumnTimeChart
                ->timeSpentVsTimeEstimatedTotalAvg($avgTimeEstVsActualTimeQuery);
        
        $chartColumnStressChart = new ColumnChartController();
        $avgStressLevelQuery = $queryColumnChartController
                ->totalAvgStressLevel();
        $avgStressLevelChart = $chartColumnStressChart
                ->showTotalAvgStressLevel($avgStressLevelQuery);
        
        $timePerCourses = new PieChartQueryController();
        $timePerCoursesChartController = new CDCharts\PieChartController;
        
        $timePerCourseQuery = $timePerCourses
                ->findTimeSpentOnCourse();
        
        $timePerCoursePieChart = $timePerCoursesChartController
                ->showTimePerCourse($timePerCourseQuery);
        
        
        //Return the chart.
        return view('CD/dashboard', $avgTimeEstVsActualTimeChart, $avgStressLevelChart, $timePerCoursePieChart);
    }

    public function createFilters()
    {
        
    }
    
    public function createNumberOfAssignmentsChart()
    {
        
        
        
    }
    
    
}

//        $datatable = Lava::DataTable();
//        $datatable->addStringColumn('Name');
//        $datatable->addNumberColumn('Donuts Eaten');
//        $datatable->addRows([
//            ['Michael',   5],
//            ['Elisa',     7],
//            ['Robert',    3],
//            ['John',      2],
//            ['Jessica',   6],
//            ['Aaron',     1],
//            ['Margareth', 8]
//        ]);
//        $pieChart = Lava::PieChart('Donuts', $datatable, [
//            'width' => 400,
//            'pieSliceText' => 'value'
//        ]);
//        $filter  = Lava::NumberRangeFilter(1, [
//            'ui' => [
//                'labelStacking' => 'vertical'
//            ]
//        ]);
//        $control = Lava::ControlWrapper($filter, 'control');
//        $chart   = Lava::ChartWrapper($pieChart, 'chart');
//        $dash = Lava::Dashboard('Donuts')->bind($control, $chart);
//         return view( 'CD/dashboard', array('dasher'=> $dash));
//        dd($fullDashboard);
//        return $fullDashboard;

//return array($lava);
//        $chartController = new AreaChartController();
//        $chart = Lava::ChartWrapper(
//                $chartController->actualVsEstimatedTime(), 'chart');
//       
//        $dashboard = Lava::Dashboard('Curricular Developer DashBoard')->bind($chart);
        
        
//        return array('dash'=>$dashboard);