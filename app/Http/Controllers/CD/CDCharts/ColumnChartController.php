<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;
use App\Http\Controllers\CD\CDCharts;

class ColumnChartController extends Controller
{
    //Here we will hold the created data table.
    private $studentTime;
    
    /**
     * Purpose: instantiate a ColumnChartController and create a Datatable.
     */
    public function __construct()
    {
        //Create the Datatable object. A data table is what we use to hold the
        //data. Similar to a database object.
        $this->studentTime = Lava::DataTable();
    }
    
    /**
     * Purpose: This function will create a standardized column chart.
     * 
     * @param type $dataTable
     * @param type $chartID
     * @param type $chartTitle
     * @return type
     */
    private function createColumnChart( $dataTable, $chartID, $chartTitle, $chartLimit = 0 )
    {
                //This is where we create the chart and add the data to it.
        $chart = Lava::ColumnChart($chartID, $dataTable, [
            'title' => $chartTitle,
                'titleTextStyle' => [
                'color'    => '#008040',
                'fontSize' => 14
            ],
            'vAxis' => ['gridlines' => ['count'=> 5],
                'minValue' => 0, 'maxValue' => $chartLimit],
            'colors' => ['#008040', '#696969', '#008040', '#696969']
        ]);
        
        return $chart;
    }
    /**
     * Purpose: This function will create a column chart.
     * 
     * @param type $avgTimeEstVsActualTime - query array of stirng.  Will hold
     * the data.
     * 
     * @return type
     */
    public function timeSpentVsTimeEstimatedTotalAvg($avgTimeEstVsActualTime)
    {
        //The chart Id this data will have.
        $chartID = 'Student Time';
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Student Time Estimate Vs Actual Time';

        //Create the rows and columns for the datatable;
        $this->studentTime->addStringColumn('All Students')
                    ->addNumberColumn('Time Estimated')
                    ->addNumberColumn('Time Spent')
                    ->addRow(['Time Estimated vs Time Spent', 
                       $avgTimeEstVsActualTime['timeEstimated'], 
                       $avgTimeEstVsActualTime['timeSpent']]);
        
        $chart = $this->createColumnChart($this->studentTime, 
                $chartID, $chartTitle );
        
        //return chart as array.
        return array('studentTime'=> $chart);
    }
    
    /**
     * Purpose of this function is to show the total avg level of stress in a 
     * bar chart.
     * 
     * @param type $avgStressLevelQuery
     */
    public function showTotalAvgStressLevel($avgStressLevelQuery)
    {
        //Chart name for array to convert to chart.
        $chartName = 'studentStress';
        $chartLimit = 10;
        
         //The chart Id this data will have.
        $chartID = 'Student Stress';
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Student Stress Level';
        
        
        //Create the rows and columns for the datatable;
        $this->studentTime->addStringColumn('Student Stress')
                    ->addNumberColumn('Average Stress Level')
                    ->addRow(['Average Stress Level', 
                       $avgStressLevelQuery['stressLevel']]);
        
        $chart = $this->createColumnChart($this->studentTime,
                $chartID, $chartTitle, $chartLimit );
        
        //return chart as array.
        return array( $chartName => $chart);
    }        
    

    

}
