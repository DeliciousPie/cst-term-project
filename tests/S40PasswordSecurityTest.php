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
            ->type('Stu001', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/home');
        
        //Log in as a Professor
        $this->visit('/login')
            ->type('Pro001', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/home');
                
        //Log in as a CD
        $this->visit('/login')
            ->type('54321', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/dashboard');
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
    
    public function testRegisterPage()
    {
        //Log in as a Student
        $this->visit('/login')
            ->type('12348', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/Student/dashboard')
            ->see("Student Registration");
        
        //Log in as a Professor
        $this->visit('/login')
            ->type('12346', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/Prof/dashboard')
            ->see("Professor Registration");
                
        //Log in as a CD
        $this->visit('/login')
            ->type('12345', 'userID')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('http://phpserver/CD/register')
            ->see("CD Registration");
    }
}
