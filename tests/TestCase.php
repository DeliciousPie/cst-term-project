<?php
use App\User;
use App\Role;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://phpserver';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
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
