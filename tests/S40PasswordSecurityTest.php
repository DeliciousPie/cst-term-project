<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class S40PasswordSecurityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        //Log in as a Student
        $this->visit('/login')
            ->type('12347', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/home');
        
        //Log in as a Professor
        $this->visit('/login')
            ->type('12346', 'userID')
            ->type('newpassword', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/home');
                
        //Log in as a CD
        $this->visit('/login')
            ->type('12345', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/home');
    }
    
    
    public function testLoginWrongPassword()
    {
        //fail log in as a Student
        $this->visit('/login')
            ->type('12347', 'userID')
            ->type('Passw0rddddd', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver//login');
        
        //fail log in as a Student
        $this->visit('/login')
            ->type('12346', 'userID')
            ->type('Passw0rddddd', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver//login');
                
        //fail log in as a Student
        $this->visit('/login')
            ->type('12345', 'userID')
            ->type('lessthansecure', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver//login');
    }
    
    public function testLoginBlank()
    {
        //fail log in as a Student
        $this->visit('/login')
            ->type('', 'userID')
            ->type('', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver//login');
    }
}
