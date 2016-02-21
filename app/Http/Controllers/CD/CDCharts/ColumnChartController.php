<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;
use App\Http\Controllers\CD\CDCharts;
use App\Http\Controllers\CD\CDChartQueries\ColumnChartQueryController;

/**
 * Purpose: Build Column charts for the CD based on what the CD passes in.
 * 
 * @author Justin Lutzko & Sean Young
 * 
 * @date Feb 20, 2016
 */
class ColumnChartController extends ColumnChartQueryController
{

    
    /**
     * Purpose: This is called from the CDDashboard controller and is used to 
     * determine the type of chart to be created.  This could be the default
     * chart which is a Timed estimated vs Time Actual chart, or it could be
     * a dynamic chart based on the fields passed in from the from on the 
     * CD dashboard.  If fields are not filled out when the form is submitted 
     * the default chart will be shown.
     * 
     * @return type will return the chart to be displayed.
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 20, 2016
     */
    public function determineChartToBeMade()
    {
        
        
        //Get the comparisons passed in from the chart form on the db controller
        $comparison1 = $this->chartParameters->comparison1;
        $comparison2 = $this->chartParameters->comparison2;
        
        //If the classSelected is all classes represented by a numeric or text
        //value create the default chart.
        if( $this->chartParameters->classSelected === 1 
                || $this->chartParameters->classSelected === "1" )
        {
         
            //Use the hard coded query in the ColumnChartQueryController
            $dataArray =  $this->performAvgComparisonQuery($comparison1,
                    $comparison2);
            
            //Generate Strings for dynamic labels
            $comp1String = $this->createChartTitles( $comparison1 );
            
            $comp2String = $this->createChartTitles( $comparison2);
            
            //Create a dynamic chart, based off of standard information passed 
            //from the CDDashboard controller.
            $chart = $this->createDynamicColumnChart($dataArray, 
                    $comp1String, $comp2String);
        }
        else
        {
          
            //Create a completly custom chart based on a single course.
            $classTitle = $this->chartParameters->classSelected;
            
            $dataArray =  $this->performAvgComparisonForCourse($comparison1,
                    $comparison2, $classTitle); 
            
            $comp1String = $this->createChartTitles( $comparison1 );
            
            $comp2String = $this->createChartTitles( $comparison2);
            
            $chart = $this->createDynamicColumnChart($dataArray, $comp1String,
                   $comp2String, $classTitle);   
        }
       
        return $chart;
    }
    
    /**
     * Purpose: This function will create a standardized column chart.
     * 
     * @param type $dataTable - attribute of the ColumnChartClass that will hold
     * the data/table to be placed in the chart.
     * 
     * @param type $chartID - The HTML ID that will be given to the chart.
     * 
     * @param type $chartTitle - The title at the top of the chart.
     * 
     * @return type Returns a full Column chart with all of the data and labels.
     * Will have two columns
     * 
     * @author Justin Luzko & Sean Young
     * 
     * @date Feb 20, 2016
     * 
     */
    private function createColumnChart( $dataTable, $chartID, $chartTitle, $chartLimit = 0 )
    {
        //This is where we create the chart and add the data to it.
        $chart = Lava::ColumnChart($chartID, $dataTable, [
            //add title
            'title' => $chartTitle,
                'titleTextStyle' => [
                'color'    => '#008040',
                'fontSize' => 14
            ],
            //set default start value.
            'vAxis' => ['gridlines' => ['count'=> 5],
                'minValue' => 0, 'maxValue' => $chartLimit],
            //Set the bar/column chart colors
            'colors' => ['#008040', '#696969', '#008040', '#696969']
        ]);
        
        return $chart;
    }
    
    /**
     * Purpose: Creates a dynamic array based on parameters passed to the 
     * controller from the form on the CD dashboard controller.
     * 
     * @param type $dataArray - data to be displayed on the chart and placed in
     * the data table.
     * 
     * @param type $comp1String - Name of first heading/label on the chart.
     * 
     * @param type $comp2String - Name of second heading/label on the chart.
     * 
     * @param type $course - $course that we are performing a query for.  Can 
     * also be all courses.
     * 
     * @return type - returns a Column chart.
     * 
     * @author Justin Lutzko & Sean Young 
     * 
     * @date Feb 20, 2016
     */
    public function createDynamicColumnChart($dataArray, $comp1String, 
            $comp2String, $course='All Courses')
    {
        //The chart Id this data will have.
        $chartID = 'StudentParam';
        
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Student ' . $comp1String . ' Vs ' . 
                $comp2String . ' For ' . $course;

        //Create the rows and columns for the datatable;
        $this->studentData->addStringColumn('All Students')
                    ->addNumberColumn($comp1String)
                    ->addNumberColumn($comp2String)
                    //Column labels at bottom of chart. plus columns and labels.
                    ->addRow([$comp1String .' vs '. $comp2String, 
                       $dataArray['param1'], 
                       $dataArray['param2']]);
        
        //Creates a standard CDP column chart with two bars.
        $chart = $this->createColumnChart($this->studentData, 
                $chartID, $chartTitle );
        
        //return chart as array.
        return array('studentData'=> $chart);
    }
    
    /**
     * Purpose: This function will create a column chart. It will be a hardcoded
     * chart that will calculate total averages based on timeEstimated and 
     * timeSpent.
     * 
     * @param type $avgTimeEstVsActualTime - query array of stirng.  Will hold
     * the data.
     * 
     * @return type return a column chart.
     * 
     * @author Justin Lutzko & Sean Young
     * 
     * @date Feb 20 2016
     */
    public function timeSpentVsTimeEstimatedTotalAvg($avgTimeEstVsActualTime)
    {
        //The chart Id this data will have.
        $chartID = 'Student Time';
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Student Time Estimate Vs Actual Time';

        //Create the rows and columns for the datatable;
        $this->studentData->addStringColumn('All Students')
                    ->addNumberColumn('Time Estimated')
                    ->addNumberColumn('Time Spent')
                    ->addRow(['Time Estimated vs Time Spent', 
                       $avgTimeEstVsActualTime['timeEstimated'], 
                       $avgTimeEstVsActualTime['timeSpent']]);
        
        $chart = $this->createColumnChart($this->studentData, 
                $chartID, $chartTitle );
        
        //return chart as array.
        return array('studentTime'=> $chart);
    }
    
    /**
     * Purpose of this function is to show the total avg level of stress in a 
     * bar chart.
     * 
     * @param type $avgStressLevelQuery
     * 
     * @author Justin Lutzko
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
        $this->studentData->addStringColumn('Student Stress')
                    ->addNumberColumn('Average Stress Level')
                    ->addRow(['Average Stress Level', 
                       $avgStressLevelQuery['stressLevel']]);
        
        $chart = $this->createColumnChart($this->studentData,
                $chartID, $chartTitle, $chartLimit );
        
        //return chart as array.
        return array( $chartName => $chart);
    }        
    
    /**
     * 
     * Purpose: createChartTitles will allow us to create dynamic titles and
     * labels for our charts.  The labels are based on the data passed in from
     * the chart from on the CD dashboard.
     * 
     * @param type $comparison - Parameter passed to the controller via the form
     * on the CD dashboard.
     * 
     * @return string - Retunr a string formatted to add to titles and labels.
     * 
     * @author Justin Lutzko & Sean Young
     * 
     * @date Feb 20 2016
     */
    public function createChartTitles( $comparison )
    {
        //result ot be returned.
        $result = '';
        
        //Compare column heading in all if statements.
        if( $comparison === 'timeEstimated')
        {
            //Add string based on column heading.
            $result = 'Time Estimated';
        }
        else if ( $comparison === 'timeSpent' )
        {
            $result = 'Time Actual';
        }
        elseif ( $comparison === 'stressLevel' )
        {
            $result = 'Stress Level';
        }
        
        return $result;
    }
}
