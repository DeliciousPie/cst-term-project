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

//    public function testPerformAvgComparisonQuery()
//    {
//        $this->withoutMiddleware();
//        
//        $stressLevel = "stressLevel";
//        $timeSpent = "timeSpent";
//        $timeEstimated = "timeEstimated";
//        
//        $timeEstNumber = 11.66667;
//        $timeSpentNum = 12.66667;
//        $stressLevelNum = 6.3333;
//        
//        $queryController = new \App\Http\Controllers\CD\CDChartQueries\ColumnChartQueryController();
//        $queryResult = $queryController->performAvgComparisonQuery($stressLevel, $timeSpent);
//        $this->assertTrue($stressLevelNum, $queryResult['param1']);
//        $this->assertTrue($timeSpentNum, $queryResult['param2']);
//        
//        $queryResult = $queryController->performAvgComparisonQuery($timeSpent, $stressLevel);
//        $this->assertTrue($timeSpentNum, $queryResult['param1']);
//        $this->assertTrue($stressLevelNum, $queryResult['param2']);
//         
//        $queryResult = $queryController->performAvgComparisonQuery($timeEstimated, $stressLevel);
//        $this->assertTrue($timeEstNumber, $queryResult['param1']);
//        $this->assertTrue($stressLevelNum, $queryResult['param2']);
//        
//        $queryResult = $queryController->performAvgComparisonQuery($stressLevel, $timeEstimated);
//        $this->assertTrue($stressLevel, $queryResult['param1']);
//        $this->assertTrue($timeEstNumber, $queryResult['param2']);
//        
//        $queryResult = $queryController->performAvgComparisonQuery($timeSpent, $timeSpent);
//        $this->assertTrue($timeSpentNum, $queryResult['param1']);
//        $this->assertTrue($timeSpentNum, $queryResult['param2']);
//        
//        $queryResult = $queryController->performAvgComparisonQuery($stressLevel, $stressLevel);
//        $this->assertTrue($stressLevelNum, $queryResult['param1']);
//        $this->assertTrue($stressLevelNum, $queryResult['param2']);
//        
//        $queryResult = $queryController->performAvgComparisonQuery($timeEstimated, $timeEstimated);
//        $this->assertTrue($timeEstNumber, $queryResult['param1']);
//        $this->assertTrue($timeEstNumber, $queryResult['param2']);
//    }
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
             ->select("stressLevel", 'comparison2')
             ->press('Submit')
             ->seePageIs('/dashboard')
//             ->see('Average' )
             ->see('Stress Level')
            
             ->see('For COMM101');  
    }
    
//    public function testSubmitNewChartStressAndTimeActual()
//    {
//        $this->baseUrl = 'http://phpserver/CD';
//        
//        $user = $this->createUser();
//        $this->flushSession();
//        //Look on the page too see if we can find the fake student activity.
//        $this->actingAs($user)
//             ->withSession(['foo1' => 'bar1'])
//;
////        $this
////             ->call('POST', '/dashboardCustomChart',
////                ["5" => 'chartSelected',
////                "COMM101" => 'classSelected',
////                "stressLevel" => 'comparison1', 
////                "timeSpent" => 'comparison2'])
////            $this->see('Average Student Stress Level Vs Time Actual For COMM101')
////             ->see(6.3333)
////             ->see(12.6666); 
//    }
    
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
