<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\CD;
use App\User;
class CDInfoTest extends TestCase
{
protected $baseurl = 'http://phpserver/';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCDRegistration()
    {
        //Sign into website as unconfirmed CD
        Session::start();
        $this->call('POST', '/login', [
            'userID' => 'adm219',
            'password' => 'password',
            '_token' => csrf_token()
        ]);

        
        //Fill out registration form
        $this->visit('http://phpserver/CD/dashboard')
                ->type('newpassword', 'password')
                ->type('newpassword', 'confirmPassword')
                ->type('Mark', 'firstName')
                ->type('ThinksHeCanGoSkiing', 'lastName')
                ->select('agbio', 'areaOfStudy')
                ->select('CPHR', 'school' )
                ->type('email@email.net', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/CD/dashboardCustomChart');
        
        //Check to see if changes have been made in the database
        $this->seeInDatabase('CD', [
            'userID' => 'adm219',
            'fName' => 'Mark',
            'lName' => 'ThinksHeCanGoSkiing',
            'email'=> 'email@email.net'        
        ]);
    }
    
    /*
     * Testing if the the two passwords match
     */
    public function testFailCaseNonMatchingPasswords()
    {
        //log in user
        Session::start();
        $this->call('POST', '/login', [
            'userID' => '12345',
            'password' => 'password',
            '_token' => csrf_token()
        ]);
        
        //Fill out registration form
        $this->visit('http://phpserver/CD/dashboard')
                ->type('newpassword', 'password')
                ->type('wrongpassword', 'confirmPassword')
                ->type('Justin', 'firstName')
                ->type('IAMTHECAPTAINNOW', 'lastName')
                ->select('agbio', 'areaOfStudy')
                ->select('CPHR', 'school' )
                ->type('code@crush.net', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/CD/dashboard');
                
        //check to see that the passwords don't match shows up
        $this->see("Passwords Don't Match");       
    }
    
}
