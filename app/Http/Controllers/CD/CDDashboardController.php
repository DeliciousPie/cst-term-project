<?php

namespace App\Http\Controllers\CD;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CDDashboardRequest;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use App\Http\Controllers\CD\CDChartQueries\ColumnChartQueryController;
use App\Http\Controllers\CD\CDCharts\ColumnChartController;
use App\Http\Controllers\CD\CDChartQueries\PieChartQueryController;
use App\Http\Controllers\CD\CDCharts\LineChartController;
use Auth;
use App\Course;

class CDDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('cdmanager');
    }
    /**
     * Purpose: This will create a standard dashboard for the CD. Is executed
     * when a get request is made to the dashboard page.  Will always return
     * a column chart comparing time estimated and actual time spent. This 
     * we be compared by the total avg of all course and each column
     * 
     * @return return a dashboard and some standard chart, with a list of all
     * the courses.
     * 
     * @author Justin Lutzko & Sean young
     * 
     * @date Feb 20, 2016
     */
    public function createDefaultDashboard(CDDashboardRequest $request) 
    {
        //Checks if user is confirmed and if they are continue else get a 
        //redirect to CD registration page.
        $this->isUserConfirmed();
        $chartParameters = $request;
        //Sets default parameters "passed in" from the form on the CD dashbaord.
        $chartParameters->chartSelected ='5';
        $chartParameters->classSelected = 1;
        $chartParameters->comparison1 = 'timeEstimated';
        $chartParameters->comparison2 ='timeSpent';
        
        //Create a new class.
        $chart = new ColumnChartController($chartParameters);
        
        //Determine charts to be made and return a column chart.
        $result = $chart->determineChartToBeMade();
       
        //Get a list of all the courses to populate the form with.
        $allCourses = $this->queryListOfCoursesForForm();
        
        //Add list of courses to the chart query.
        $result['courses'] = $allCourses;
        
        //Return the chart, list of courses and the call to the view.
        return view('CD/dashboard')->with($result);
        
    }

    /**
     * Purpose: Called when a post request is made from dashboardCustomChart.
     * Will build a custom chart based on the parameters from the form on the CD
     * dashboard.
     * 
     * @return return a dashboard and some standard chart, with a list of all
     * the courses.
     * 
     * @author Justin Lutzko & Sean young
     * 
     * @date Feb 20, 2016 
     */
    public function createCustomChart(CDDashboardRequest $request)
    {
         //Checks if user is confirmed and if they are continue else get a 
        //redirect to CD registration page.
        $this->isUserConfirmed();
        
        //Set post parameters to custom array name.
        $chartParameters = $request;
        dd($chartParameters->classSelected);
        //declare result to be returned.
        $result;
      
        //if ChartParameters are set determine the chart based on them
        if( isset($chartParameters) && count($chartParameters) > 0 ) 
        {
            
            $result = $this->determineChartCase($chartParameters);
        }
        else
        {
            //If not set just create the default dashboard.
            $result = $this->createDefaultDashboard();
        }

        //Get all the courses.
        $allCourses = $this->queryListOfCoursesForForm();

        $result['courses'] = $allCourses;
        
        return view('CD/dashboard')->with($result);
    }
    
    /**
     * Purpose: Get all the course currently in database.
     * 
     * @return type $courses - associative array of all the course in string 
     * from.
     * 
     * @author Justin Lutzko & Sean young
     * 
     * @date Feb 20, 2016 
     */
    public function queryListOfCoursesForForm()
    {
        
        $courses = Course::all();
        
        $courses = json_decode(json_encode($courses), true);
        
        return $courses;
    }
    
    /**
     * Purpose: This function will determine the type of chart we will be
     * making.  It looks at the chart selected parameter and bases its' decision
     * on that by going through a series of cases.
     * 
     * @return type $courses - associative array of all the course in string 
     * from.
     * 
     * @author Justin Lutzko & Sean young
     * 
     * @date Feb 20, 2016 
     */
    public function determineChartCase($chartParameters)
    {
       
        //Determine if chart is set, if not use the default case of 0.
        if( !isset($chartParameters->chartSelected))
        {
            $chartParameters->chartSelected = 0;
        }
        
        //Go through each case to make charts.
        switch ( $chartParameters->chartSelected ) {
            case '1':
                //Pie Chart

 
                break;
            case '2':
                //Donut Chart
                break;
            case '3':
                //Scatter Chart
                break;
            case '4':
                //Bubble Chart
                break;
            case '5':
                
                //Column Chart
                $chart = new ColumnChartController($chartParameters);
                
                $result = $chart->determineChartToBeMade();
                
                break;
            case '6':
                //Bar Chart
                break;
            case '7':
                //Combo Chart
                break;
            case '8':
                //Area Chart
                break;
            case '9':
                //Line Chart
                $chart = new LineChartController($chartParameters);
                
                $result = $chart->determineChartToBeMade();
                
                break;
            default:
                //Build defualt chart. See createDefaultDashboard comment for
                //more info on a default chart.
                $chart = new ColumnChartController($chartParameters);
                $result = $chart->determineChartToBeMade();
        }
        return $result;
    }
    
    /**
     * Purpose: Will determine if the user is a confirmed CD. If they are not 
     * they will be redirected to the registration page.
     * 
     * @return type a redirect.
     */
    public function isUserConfirmed()
    {
        //get user signed in
        $confirmed = Auth::user()->confirmed;
  
        
        if( !$confirmed )
        {
            //perform redirect to registration page if not confirmed.
            return redirect('CD/register');
        }
 
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