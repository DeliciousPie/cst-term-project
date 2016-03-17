<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CDQueryController;

class S49Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetStudentsByCourse()
    {
        $this->withoutMiddleware();
        
        $CDQuery = new CDQueryController();
        
        $result = $CDQuery->getStudentsByCourse('COMM101');
        
        
    }
}
