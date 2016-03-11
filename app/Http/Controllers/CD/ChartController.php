<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;

abstract class ChartController extends Controller
{ 
    //Store all of the chart parameters passed in from the form on the CD
    //dashboard.
    protected $chartParameters;
    
    /**
     * Purpose: instantiate a ColumnChartController and create a Datatable.
     */
    public function __construct($chartParameters=array())
    {  

        $this->chartParameters = $chartParameters;
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
        else if( $comparison === 'spent')
        {
            $result = 'Time Actual';
        }
        else if( $comparison === 'estimated')
        {
            $result = 'Time Estimated';
        }
        return $result;
    }
    
    /**
     * Purpose: This will get the default columns if nothing is selected.
     * 
     * @param type $comp - the paramter to be compared.
     * @return string return the proper colulmn name for the queries.
     */
    public function getTimeSpentandTimeEstiamtedColumns($comp )
    {
        if( $comp === 'spent' )
        {
            $comp = 'timeSpent';
        }
        
        if( $comp === 'estimated' )
        {
            $comp = 'timeEstimated';
        }
        
        return $comp;
    }
    
}
