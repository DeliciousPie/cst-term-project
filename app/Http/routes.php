<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    
    //Holds authentication routes
    Route::auth();

    //Loads home page.
    Route::get('/home', 'HomeController@index');
    
    //Loads welcome view without controller.
    Route::get('/', function () {
        return view('/home');
    });
    
    //Loads about page.
    Route::get('/about', 'AboutController@index');
   
    /**
     * This route group is responsible for directing users with a Student 
     *credentials.  It utilizes the auth middleware.
     * 
     * Anything that has Student/ in the url needs to go through this route
     * group.  It provide the secerity that only students may access these 
     * routes.
     */
    Route::group(array('prefix' => 'Student', 'namespace' => 'Student', 
        'middleware' => 'studentmanager'), function () {
        
        //Will load a dashboard via the Pages Controller.
        Route::get('/dashboard', 'PagesController@loadDashboard'); 
        
        //Inserts all of the Student Info via registration and then loads a 
        //view.
        Route::post('/dashboard', 'StudentInfoController@insertStudent');
        
        //This route will show all of the activities that are associated with a 
        //student.
        Route::get('/activities', 'StudentActivityController@showAllActivities');
        
        //This route will add the information to the selected activity.
        Route::post('/activities', 'StudentActivityController@updateInfo');
        
        
        
    });
    
   /**
     * This route group is responsible for directing users with a CD 
     * credentials.  It utilizes the auth middleware.
     * 
     * Anything that has CD/ in the url needs to go through this route
     * group.  It provide the secerity that only students may access these 
     * routes.
     */
    Route::group(array('prefix' => 'CD', 'namespace' => 'CD', 
        'middleware' => 'cdmanager'), function () {
            
        //Will load a dashboard via the Pages Controller.
        Route::get('/dashboard', 'PagesController@loadDashboard');
        
        //Loads the registration page on first time login.
        Route::post('/dashboard', 'CDInfoController@insertCD');    
        
        // Course Assignment Grouping 
        Route::get('CourseAssignmentMain','CourseAssignmentController@LoadView'); 
        Route::post('CourseAssignmentMain', 'CourseAssignmentController@uploadCSVFiles' );
        
        Route::post('CourseAssignmentMain/getProfAndStu','CourseAssignmentController@getProfAndStud'); 
        
        //Loads the Activity Manager page.
        Route::get('/manageActivity', 'ActivityManagerController@loadProfessors');
        Route::post('/manageActivity/loadSelectedProfsCourses', 'ActivityManagerController@loadSelectedProfsCourses');
        Route::post('/manageActivity/loadSelectedCoursesActivities', 'ActivityManagerController@loadSelectedCoursesActivities');
        Route::post('/manageActivity/addActivity', 'ActivityManagerController@addActivity');
    });
    
   /**
     * This route group is responsible for directing users with a Prof 
     * credentials.  It utilizes the auth middleware.
     * 
     * Anything that has Prof/ in the url needs to go through this route
     * group.  It provide the secerity that only students may access these 
     * routes.
     */
    Route::group(array('prefix' => 'Prof', 'namespace' => 'Prof', 
        'middleware' => 'profmanager'), function () {
        
        //Will load a dashboard via the Pages Controller.        
        Route::get('/dashboard', 'PagesController@loadDashboard'); 
        
                //Loads the registration page on first time login.
        Route::post('/dashboard', 'ProfInfoController@insertProf');
    });
});










