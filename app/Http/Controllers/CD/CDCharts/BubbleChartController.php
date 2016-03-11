<?php

namespace App\Http\Controllers\CD\CDCharts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CD\CDChartQueries\BubbleChartQueryController;
use Lava;

/**
 * Purpose: The purpose of this class is to create dynamic bubble charts. It 
 * extends the BubbleChartQueryController which contains the queries that the 
 * class will use.  The query controller will extend an average class
 * ChartManagerController which is responsible for items common to all charts.
 * 
 * @author Jusitn Lutzko
 * 
 * @date March 9, 2016
 * 
 */
class BubbleChartController extends BubbleChartQueryController
{
    /**
     * Purpose: This is called from the CDDashboard controller and is used to 
     * determine the type of bubble chart to be created. This
     * will be a dynamic chart based on the fields passed in from the form
     * base on the CD dashboard.  If fields are not filled out when 
     * the form is submitted the default chart will be shown.
     * 
     * @return type will return the chart to be displayed.
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date March 10, 2016
     */
    public function determineChartToBeMade()
    {
        
        $chart = null;
        
        //Get the comparisons passed in from the chart form on the db controller
        $comparison1 = $this->chartParameters->comparison1;
        $comparison2 = $this->chartParameters->comparison2;
        
        //If the classSelected is all classes represented by a numeric or text
        //value create the default chart.
        if( $this->chartParameters->classSelected === 1 
                || $this->chartParameters->classSelected === "1" )
        {
         
            //Here we will determine the queries that will pertain to all 
            //classes.
            
            $dataArray = $this->allCoursesComparison($comparison1, 
                    $comparison2);
            
                        //Generate Strings for dynamic labels
            $comp1String = $this->createChartTitles( $comparison1 );
            
            $comp2String = $this->createChartTitles( $comparison2);
            
            //Create a dynamic chart, based off of standard information passed 
            //from the CDDashboard controller.
            $chart = $this->createDynamicBubbleChart($dataArray, 
                    $comp1String, $comp2String);
        }
        else
        {
           
            //Create a completly custom chart based on a single course.
            $classTitle = $this->chartParameters->classSelected;
            
            //Here we perform queries for individual classes selected.
            
        }

        return $chart;
    }
    
    /**
     * Purpose: This function will create a standardized bubble chart.
     * 
     * @param type $dataTable - attribute of the BubbleChartClass that will hold
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
    private function createBubbleChart( $dataTable, $chartID, $chartTitle, 
            $chartLimit = 0 )
    {
        //This is where we create the chart and add the data to it.
        $chart = Lava::BubbleChart($chartID, $dataTable, [
            //add title
            'title' => $chartTitle,
                'titleTextStyle' => [
                'color'    => '#008040',
                'fontSize' => 14
            ],
            'hAxis' => ['minValue' => 0],
            //set default start value.
            'vAxis' => ['gridlines' => ['count'=> 5],
                'minValue' => 0, 'maxValue' => $chartLimit]
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
     * @return type - returns a Bubble chart.
     * 
     * @author Justin Lutzko & Sean Young 
     * 
     * @date Feb 20, 2016
     */
    public function createDynamicBubbleChart($dataArray, $comp1String, 
            $comp2String, $course='All Courses')
    {
        
        //The chart Id this data will have.
        $chartID = 'StudentParam';
        
        //TODO:Fix this as titles should change.
        //This is the title that will appear at the top of the chart.
        $chartTitle = 'Average Course ' . $comp1String . ' Vs ' . 
                $comp2String . ' And Total Time Spent For ' . $course;
        
        //TODO:Change this to a datatable for the bubble chart.
        //Create the rows and columns for the datatable.
        $studentData = Lava::Datatable()
                    ->addStringColumn('Courses')
                    ->addNumberColumn($comp1String)
                    ->addNumberColumn($comp2String)
                    ->addNumberColumn('Total Time Spent:');
                    //Column labels at bottom of chart. plus columns and labels.
                    foreach( $dataArray as $data)
                    {
                        $studentData->addRow([ 
                            $data['courseID'],
                            $data['param1'], 
                            $data['param2'],
                            $data['totalHours']]);
                    }
                    
        
        //Creates a standard CDP column chart with two bars.
        $chart = $this->createBubbleChart($studentData, 
                $chartID, $chartTitle );
       
        //return chart as array.
        return array('bubbleChart'=> $chart);
    }
}