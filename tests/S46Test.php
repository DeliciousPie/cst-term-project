<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Purpose: PHPunit testing for the AJAX calls
 */
class S46Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/CD/manageActivity')
                ->see('Laravel 5');
        
        
        $this->post('/CD/manageActivity/loadSelectedProfsCourses')
                ->seeJson([
                   'created' => true, 
                ]);
        
        $this->post('/CD/manageActivity/loadSelectedCoursesActivities')
                ->seeJson([
                   'created' => true, 
                ]);
    }
}
