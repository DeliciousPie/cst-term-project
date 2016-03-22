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
use App\Http\Controllers\CD\CDQueryController;
use App\Http\Controllers\CD\ChartController;
use App\Http\Controllers\CD\CDCharts\BubbleChartController;
use App\Http\Controllers\CD\CDChartQueries\BubbleChartQueryController;
use App\Http\Controllers\CD\CDChartQueries\PieChartQueryController;
use App\Http\Controllers\CD\CDCharts\LineChartController;
use Auth;
use App\Course;
use App\Http\Requests\CDDashboardStudentCourseRequest;

class CDDashboardController extends Controller
{
    
    private $chart;
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
        $isRegistered = $this->isUserConfirmed();
        
        if( isset($isRegistered) )
        {
            return redirect($isRegistered);
        }
        
        $chartParameters = $request;
        //Sets default parameters "passed in" from the form on the CD dashbaord.
        $chartParameters->chartSelected ='5';
        $chartParameters->classSelected = 1;
        $chartParameters->comparison1 = 'timeEstimated';
        $chartParameters->comparison2 = 'timeSpent';
        
        //Create a new class.
        $this->chart = new ColumnChartController($chartParameters);
        
        //Determine charts to be made and return a column chart.
        $result = $this->chart->determineChartToBeMade();
       
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
        $isRegistered = $this->isUserConfirmed();
        
        if( isset($isRegistered) )
        {
            return redirect($isRegistered);
        }
        
        //Set post parameters to custom array name.
        $chartParameters = $request;
        
        //declare result to be returned.
        $result = null;
      
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
                $this->chart = new BubbleChartController($chartParameters);
               
                $result = $this->chart->determineChartToBeMade();
                
                break;
            case '5':
                
                //Column Chart
                $this->chart = new ColumnChartController($chartParameters);
               
                $result = $this->chart->determineChartToBeMade();
                
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
                $this->chart = new LineChartController($chartParameters);
                
                $result = $this->chart->determineChartToBeMade();
                
                break;
            default:
                //Build defualt chart. See createDefaultDashboard comment for
                //more info on a default chart.
                $this->chart = new ColumnChartController($chartParameters);
                $result = $this->chart->determineChartToBeMade();
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
        
        if( $confirmed === 0 )
        {
            //perform redirect to registration page if not confirmed.
            return('CD/register');
        }
 
    }
    
    /**
     * Purpose: This function will be called from the CD dashboard page via a
     * ajax request.  It will return all of course in a JSON object. This 
     * function will make use of the CDQueryController which holds all of the 
     * generic queries used by all the charts and various other locations.
     * 
     * @return type response() - json object(s)
     * 
     * @author Justin Lutzko & Sean Young
     * 
     * @date March 17, 2016
     */
    public function getAllCourses()
    {    
        //Instantiate the CDQueryController
        $allCoursesQuery = new CDQueryController();
        
        //Get all courses.  Should be a text array returned.
        $allCourses = $allCoursesQuery->getAllCourses();
        
        //Return a json object.
        return response()->json(['courses'=>$allCourses]);
    }
    
    /**
     * Purpose: This function will get all of the students associated with each
     * Course coming in via an ajax request on the CD dashboard page.
     * 
     * @param CDDashboardStudentCourseRequest $request - containing course(s)
     * 
     * @return JSON object with all of the students
     *  associated with each course(s)
     * 
     * @author Justin Lutzko & Sean Young
     * 
     * @date March 17, 2016
     */
    public function getAllStudentByCourse(CDDashboardStudentCourseRequest $request)
    {
        //Instantiate the CDQueryController
        $allStudentByCourseQuery = new CDQueryController();
        
        $requestInfo = $request->input('class');
        
        $studentByCourse = $allStudentByCourseQuery->getStudentsByCourse($requestInfo);
        
        return response()->json(['courseByStudent'=>$studentByCourse]);
    }
}
