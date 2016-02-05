<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Sum41Test extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProfRegistration()
    {
        //Sign into website as unconfirmed Prof
        Session::start();
        $this->call('POST', '/login', [
            'userID' => '12346',
            'password' => 'password',
            '_token' => csrf_token()
        ]);


        //Fill out registration form
        $this->visit('http://phpserver/Prof/dashboard')
                ->type('newpassword', 'password')
                ->type('newpassword', 'confirmPassword')
                ->type('Ulamog', 'firstName')
                ->type('The Ceaseless Hungerer', 'lastName')
                ->select('agbio', 'areaOfStudy')
                ->select('CPHR', 'school')
                ->type('ulamog@ulamog.ulamog', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/Prof/dashboard');

        //Check to see if changes have been made in the database
        $this->seeInDatabase('Professor', [
            'userID' => '12346',
            'fName' => 'Ulamog',
            'lName' => 'The Ceaseless Hungerer',
            'email' => 'ulamog@ulamog.ulamog'
        ]);
    }

    public function testFailCaseNonMatchingPassword()
    {
        //log in user
        Session::start();
        $this->call('POST', '/login', [
            'userID' => '666',
            'password' => 'password',
            '_token' => csrf_token()
        ]);
        
        //Fill out registration form
        $this->visit('http://phpserver/Prof/dashboard')
                ->type('newpassword', 'password')
                ->type('wrongpassword', 'confirmPassword')
                ->type('Nixilis', 'firstName')
                ->type('Ob', 'lastName')
                ->select('agbio', 'areaOfStudy')
                ->select('CPHR', 'school' )
                ->type('nixipixie@yahoo.ca', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/Prof/dashboard');
        //check to see that the passwords don't match shows up
        $this->see("Passwords Don't Match");    
    }

}
