<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Lava;

abstract class ChartController extends Controller
{
    //Here we will hold the created data table.
    protected $studentData;
    
    //Store all of the chart parameters passed in from the form on the CD
    //dashboard.
    protected $chartParameters;
    
    /**
     * Purpose: instantiate a ColumnChartController and create a Datatable.
     */
    public function __construct($chartParameters=array())
    {  
        //Create the Datatable object. A data table is what we use to hold the
        //data. Similar to a database object.
        $this->studentData = Lava::DataTable();
        $this->chartParameters = $chartParameters;
    }
}
