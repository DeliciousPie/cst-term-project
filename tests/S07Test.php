<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\CD;
use App\Role;
use App\Http\Controllers\CD\CDCharts\ColumnChartQueryController;
use App\Http\Requests\CDDashboardRequest;

class S07Test extends TestCase
{
    
    /**
     * Purpose: This will test to see if we can view the chart in the CD 
     * dashboard controller. This is for the default chart.
     * 
     * @author Justin Lutzko
     * 
     * @date Feb 21 2016
     * 
     */
    public function testViewColumnChart()
    {
        
        $this->baseUrl = 'http://phpserver/CD';
         //Find user with id 200000
        $user = User::find(200000);
        
        //If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $CD = Role::find(1);
        $user = factory(User::class)->create();

        
        //Attach the student role to the user.
        $user->attachRole($CD);
        
        //Look on the page too see if we can find the fake student activity.
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('/dashboard')
             ->see('Welcome Dallen!')
             ->see('Average Student Time Estimated Vs Time Actual For All '
                     . 'Courses')
             ->see('Time Estimated vs Time Actual')
             ->see('Select Chart')
             ->see('Select Class')
             ->see('Select Parameter')
             ->see('Submit')
             ->see(11.6666)
             ->see(12.6666)
             //this should not be on the page
             ->dontSee('Awesome')      
             ->select("5", 'chartSelected')
             ->select("COMM101", 'classSelected')
             ->select("stressLevel", 'comparison1')
             ->select("timeSpent", 'comparison2')
             ->press('Submit')
             ->seePageIs('/dashboard');

        
    }
    
    /**
     * Purpose: This will test the queries if all courses are submitted.
     * 
     * @author  Justin Lutzko & Sean Young 
     * 
     * @date Feb 25 2016
     */
    public function testViewAllCoursesStressLevelAndTimeSpent()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "1",
                 'comparison1' => "stressLevel" , 
                'comparison2' => "timeSpent"]);
        $this->see('Average Student Stress Level Vs Time Actual For All Courses')
             ->see(6.3333)
             ->see(12.6666)
             ->dontSee(11.6666); 
    }
    
    /**
     * Purpose: This will test the queries if all courses are submitted.
     * 
     * @author  Justin Lutzko & Sean Young 
     * 
     * @date Feb 25 2016
     */
    public function testViewAllCoursesTimeEstimatedAndStressLevel()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "1",
                 'comparison1' => "timeEstimated" , 
                'comparison2' => "stressLevel"]);
        $this->see('Average Student Time Estimated Vs Stress Level For All Courses')
             ->see(6.3333)
             ->see(11.6666)
              ->dontSee(12.6666); 
    }
    
    /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartStressAndTimeActual()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "stressLevel" , 
                'comparison2' => "timeSpent"]);
        $this->see('Average Student Stress Level Vs Time Actual For COMM101')
             ->see(6)
             ->see(13); 
    }
    
    
    /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartTimeActualAndTimeActual()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeSpent" , 
                'comparison2' => "timeSpent"]);
        $this->see('Average Student Time Actual Vs Time Actual For COMM101')
             ->see(6)
             ->see(13)
             ->dontSee(10.5);
 
    }
    
    
    /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartTimeActualAndStress()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeSpent" , 
                 'comparison2' => "stressLevel"]);
        $this->see('Average Student Time Actual Vs Stress Level For COMM101')
             ->see(6)
             ->see(13)
             ->dontSee(10.5); 
    }
    
    
    
    /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartStressAndStess()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "stressLevel" , 
                'comparison2' => "stressLevel"]);
        $this->see('Average Student Stress Level Vs Stress Level For COMM101')
             ->see(6)
             ->dontSee(13); 
    }
    
            /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
        public function testSubmitNewChartTimeEstimateAndTimeActual()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeEstimated" , 
                'comparison2' => "timeSpent"]);
        $this->see('Average Student Time Estimated Vs Time Actual For COMM101')
             ->see(10.5)
             ->see(13); 
    }
    
            /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
        public function testSubmitNewChartTimeActualAndTimeEstimated()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeSpent" , 
                'comparison2' => "timeEstimated"]);
        $this->see('Average Student Time Actual Vs Time Estimated For COMM101')
             ->see(10.5)
             ->see(13); 
    }
    
            /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartStressAndTimeEstimated()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "stressLevel" , 
                'comparison2' => "timeEstimated"]);
        $this->see('Average Student Stress Level Vs Time Estimated For COMM101')
             ->see(6)
             ->see(10.5)
             ->dontSee(13); 
    }
    
            /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartTimeEsimtatedAndStess()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeEstimated" , 
                'comparison2' => "stressLevel"]);
        $this->see('Average Student Time Estimated Vs Stress Level For COMM101')
             ->see(6)
             ->see(10.5)
             ->dontSee(13); 
    }
    
            /**
     * Purpose: This will test loading a chart and see the information that is
     * on it.  This performs a post request with values that the user can 
     * submit
     * 
     * @author Justin Lutzko and Sean Young
     * 
     * @date Feb 25 2016
     * 
     */
    public function testSubmitNewChartTimeEstimatedAndTimeEstimated()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();

        $this->actingAs($user)
                
             ->call('POST', '/dashboard',
                ['chartSelected' => "5",
                 'classSelected' => "COMM101",
                 'comparison1' => "timeEstimated" , 
                'comparison2' => "timeEstimated"]);
        $this->see('Average Student Time Estimated Vs Time Estimated For COMM101')
             ->see(10.5)
             ->dontSee(13); 
    }
    
    

    
    
    /**
     * Purpose: To create a user to log on a a CD.  Re-occurs all the time.
     * 
     * @return CD user
     * 
     * @author Jusitn Lutzko 
     * 
     * @date Feb 21 2016
     */
    public function createUser()
    {
        //Find user with id 200000
        $user = User::find(200000);
        
        //If the user exists, delete it
        if( $user != null )
        {
           $user->delete(); 
        }
        
        //Get student roles from db
        $CD = Role::find(1);
        $user = factory(User::class)->create();

        
        //Attach the student role to the user.
        $user->attachRole($CD);
       return $user;
    }
}
