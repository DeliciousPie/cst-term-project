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
    
    public function runTests()
    {
        $this->testSubmitAllCoursesAndUsers(); 
     
    }
    /**
     * Purpose: The purpose of this unit test is to pass of the possible data
     * from the fields and get results back.
     * 
     */
    public function testSubmitAllCoursesAndUsers()
    {
            
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
        
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
                 'comparison1' => "stressLevel" , 
                 'comparison2' => "timeSpent",
                 'comparison3' => "timeEstimated"]);
        $this->see('Average Stress Level, Time Actual And Time Estimated')
             ->see(7)
             ->see(17)
             ->dontSee(11.6666); 
    }
}
