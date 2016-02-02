<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Student\StudentActivityController;

class S32Test extends TestCase {

    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample() {
        $this->assertTrue(true);
    }

    public function testShowAllActivities() {
        $this->visit('Student/activities')
                ->see('Student Activities')
                ->dontSee('Awesome');
    }

}
