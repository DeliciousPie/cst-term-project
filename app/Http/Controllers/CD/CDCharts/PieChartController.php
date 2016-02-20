<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;

class PieChartController extends Controller
{
    //Here we will hold the created data table.
    private $pieDataTable;
    
    /**
     * Purpose: instantiate a ColumnChartController and create a Datatable.
     */
    public function __construct($chartParameters=array())
    {
        //Create the Datatable object. A data table is what we use to hold the
        //data. Similar to a database object.
        $this->pieDataTable = Lava::DataTable();
    }
    
    /**
     * Purpose: This function will create a standardized column chart.
     * 
     * @param type $dataTable - 
     * @param type $chartID
     * @param type $chartTitle
     * @return type
     */
    private function createColumnChart( $dataTable, $chartID, $chartTitle, $chartLimit = 0 )
    {
        //This is where we create the chart and add the data to it.
        $chart = Lava::PieChart($chartID, $dataTable, [
            'title'  => $chartTitle,
             'is3D'   => true,
             'slices' => [
                 ['offset' => 0.2],
                 ['offset' => 0.25],
                 ['offset' => 0.3]
             ]
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
    public function showTimePerCourse($courses=array())
    {
        //The chart Id this data will have.
        $chartID = 'Course Time';
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Time Spent On Assignment per Course';

        //Create the rows and columns for the datatable;
       $this->pieDataTable->addStringColumn('Courses')
                    ->addNumberColumn('Percent');
        foreach( $courses as $course )
        {
            $this->pieDataTable->addRow([$course['Course'], 
                       $course['Time Spent']]);
        }
        
        $chart = $this->createColumnChart($this->pieDataTable, 
                $chartID, $chartTitle );
        
        //return chart as array.
        return array('amountOfTimeSpentOnCourses' => $chart);
    }
    
   
}
