 <?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Sum41Test extends TestCase
{

    /**
     * Test a successful initialization of a Professor user. This test simualtes
     * a user logging in for the first time and entering their information. If
     * completed successfully there will be a new record in the Professor table.
     */
    public function testProfInitialization()
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
                ->type('The Ceaseless Hunger', 'lastName')
                ->select('CPHR', 'school')
                ->select('agbio', 'areaOfStudy')
                ->type('ulamog@ulamog.ulamog', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/Prof/dashboard');

        //Check to see if changes have been made in the database
        $this->seeInDatabase('users', [
            'userID' => '12346',
            'name' => 'Ulamog',
            'email' => 'ulamog@ulamog.ulamog',
            'confirmed' => '1'
        ]);
    }

    /**
     * This test simulates a non-initialized professor user logging in for the 
     * first time and entering in their information but providing two different
     * passwords. The site will redirect them back to the form, provide a 
     * message about why they were unsuccessful, and not add them to 
     * the database.
     */
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
                ->select('CPHR', 'school')
                ->type('nixipixie@yahoo.ca', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/Prof/dashboard');
        //check to see that the passwords don't match shows up
        $this->see("Passwords Don't Match");
        //Make sure they didn't go in the DB
        $this->notSeeInDatabase('Professor', [
            'userID' => '666',
            'fName' => 'Nixilis',
            'lName' => 'ob',
            'email' => 'nixipixi@yahoo.ca'
        ]);
    }
   
    /**
     * This test will simulate an uninitialized user entering their information
     * correctly into the form but making their last name an SQL command. If the
     * command executes, the entire Professor table will be dropped. The site
     * should strip the command out and enter it as a string for their name.
     */
   /* public function testSQLInjection()
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
                ->type('newpassword', 'confirmPassword')
                ->type('Nixilis', 'firstName')
                ->type('drop table Professor;', 'lastName')
                ->select('agbio', 'areaOfStudy')
                ->select('CPHR', 'school')
                ->type('nixipixie@yahoo.ca', 'email')
                ->press('Submit')
                ->seePageIs('http://phpserver/Prof/dashboard');
        //check to see that the user is made with the last name of 
        //  'drop table Professor;'. If the command executes the professor table
        //  won't exist so this will super fail
        $this->seeInDatabase('Professor', [
            'userID' => '666',
            'fName' => 'Nixilis',
            'lName' => 'drop table Professor;',
            'email' => 'nixipixie@yahoo.ca'
        ]);
    } */
}
