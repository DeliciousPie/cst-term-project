<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CDQueryController;
use App\User;
use App\Role;
use App\Course;

/**
 * Purpose: The purpose this unit test is to test the Bubblechart story.
 */
class S49Test extends TestCase
{
    //COMM101 stats
    const comm101Stress = 5;
    const comm101Actual = 5;
    const comm101Estimated = 6;
    
    //COMM210 stats
    const comm210Stress = 7;
    const comm210Actual = 12;
    const comm210Estimated = 14;
    
    //Random number that shoun't be seen
    const dontSeeVariable = 20000;
    
    //Text that will show up in the title of the chart
    const timeActual = "Time Actual";
    const timeEstimate = "Time Estimated";
    const stressLevel = "Stress Level";
    
    //value passed to the server from the parameter on the form
    const parameterStress = "stressLevel";
    const parameterEstimate = "timeEstimated";
    const parameterActual = "timeSpent";
    
    //Name of the courses we use for testing
    const testCourse1 = "COMM101";
    const testCourse2 = "COMM210";
    
    /**
     * Purpose: The purpose of this unit test is to pass of the possible data
     * from the fields and get results back.
     * 
     */
    public function testSubmitAllCoursesAndUsers()
    {  
        //Reset the database to make sure we are using constant data.
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
        //Login
       $this->visit('/login')
            ->type('54321', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/dashboard');
                
        $this->visit('/CD/dashboard'); 
        
        //Make a call and get a chart back
        $this->call('POST', '/CD/dashboard',
                ['chartSelected' => "4",
                 'courseList' =>[        
                    0 => "COMM210",
                    1 => "COMM101"],
                 'studentList' => [        
                    0 => "COMM210, 12347",
                    1 => "COMM101, 12347",],   
                 'comparison1' => self::parameterStress , 
                 'comparison2' => self::parameterActual,
                 'comparison3' => self::parameterEstimate]);
        $this->see('Average ' . self::stressLevel . ', ' . self::timeActual . ' And ' . self::timeEstimate)
             ->see(self::comm101Actual)
             ->see(self::comm101Stress)
             ->see(self::comm101Estimated)
             ->see(self::comm210Actual)
             ->see(self::comm210Estimated)
             ->see(self::comm210Stress)
             ->see(self::testCourse1)
             ->see(self::testCourse2)
             ->dontSee(self::dontSeeVariable); 
    }
    
    /**
     * Purpose: Make sure the right title shows up.
     */
    public function testTitleEstimateActualStress()
    {
           $this->visit('/login')
            ->type('54321', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/dashboard');
                
        $this->visit('/CD/dashboard'); 
        
        $this->call('POST', '/CD/dashboard',
                ['chartSelected' => "4",
                 'courseList' =>[        
                    0 => "COMM210",
                    1 => "COMM101"],
                 'studentList' => [        
                    0 => "COMM210, 12347",
                    1 => "COMM101, 12347",],   
                 'comparison1' => self::parameterEstimate , 
                 'comparison2' => self::parameterActual,
                 'comparison3' => self::parameterStress]);
        $this->see('Average ' . self::timeEstimate . ', ' . self::timeActual . ' And ' . self::stressLevel)
             ->see(self::comm101Actual)
             ->see(self::comm101Stress)
             ->see(self::comm101Estimated)
             ->see(self::comm210Actual)
             ->see(self::comm210Estimated)
             ->see(self::comm210Stress)
             ->see(self::testCourse1)
             ->see(self::testCourse2)               
             ->dontSee(self::dontSeeVariable); 
    }
    
    /**
     * Purpose: Make sure the right title shows up.
     */
    public function testTitleActualStressEstimate()
    {
                        $this->visit('/login')
            ->type('54321', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/dashboard');
                
        $this->visit('/CD/dashboard'); 
        
        $this->call('POST', '/CD/dashboard',
                ['chartSelected' => "4",
                 'courseList' =>[        
                    0 => "COMM210",
                    1 => "COMM101"],
                 'studentList' => [        
                    0 => "COMM210, 12347",
                    1 => "COMM101, 12347",],   
                 'comparison1' => self::parameterActual , 
                 'comparison2' => self::parameterStress,
                 'comparison3' => self::parameterEstimate]);
        $this->see('Average ' . self::timeActual . ', ' . self::stressLevel . ' And ' . self::timeEstimate)
             ->see(self::comm101Actual)
             ->see(self::comm101Stress)
             ->see(self::comm101Estimated)
             ->see(self::comm210Actual)
             ->see(self::comm210Estimated)
             ->see(self::comm210Stress)
             ->see(self::testCourse1)
             ->see(self::testCourse2)
             ->dontSee(self::dontSeeVariable); 
    }
    
    /**
     * Purpose: Make sure the right title shows up.
     */
    public function testTitleStressEstimateActual()
    {
                        $this->visit('/login')
            ->type('54321', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/dashboard');
                
        $this->visit('/CD/dashboard'); 
        
        $this->call('POST', '/CD/dashboard',
                ['chartSelected' => "4",
                 'courseList' =>[        
                    0 => "COMM210",
                    1 => "COMM101"],
                 'studentList' => [        
                    0 => "COMM210, 12347",
                    1 => "COMM101, 12347",],   
                 'comparison1' => self::parameterStress , 
                 'comparison2' => self::parameterEstimate,
                 'comparison3' => self::parameterActual]);
        $this->see('Average ' . self::stressLevel . ', ' . self::timeEstimate . ' And ' . self::timeActual)
             ->see(self::comm101Actual)
             ->see(self::comm101Stress)
             ->see(self::comm101Estimated)
             ->see(self::comm210Actual)
             ->see(self::comm210Estimated)
             ->see(self::comm210Stress)
             ->see(self::testCourse1)
             ->see(self::testCourse2)
             ->dontSee(self::dontSeeVariable); 
    }
}
