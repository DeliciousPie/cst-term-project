<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Student\StudentActivityController;
use App\User;
use App\Role;
use App\Course;
use App\Section;
use App\Activity;
use App\StudentActivity;

class S32Test extends TestCase {

  
    
    /**
     * Purpose: Will test the page to confirm that the user can see the sutdent
     * activities page.
     * 
     * @author Justin Lutzko CST229 and Dallen Barr CST218
     */
    public function testShowAllActivities() {
        
        
        //If the user exists, delete it
        $user = User::find(200);
        if( $user != null )
        {
           $user->delete(); 
        }

        $Student = Role::find(3);
        
        //Log in as user
        $user = factory(User::class)->create();

        $user->attachRole($Student);
        
        $this->actingAs($user)
             ->withSession(['foo' => 'bar'])
             ->visit('Student/activities')
             ->see('Student Activities')
             ->see('Assignment')
             ->see('CDP')
             ->dontSee('Awesome');
    }
    
    public function testActivityFormAllValid()
    {
        $user = User::find(200);
        if( $user != null )
        {
           $user->delete(); 
        }
        $Student = Role::find(3);
        
        $user = factory(User::class)->create();

        $user->attachRole($Student);
        
        //log in as user
        $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->visit('Student/activities')
            ->see('Student Activities')
            ->dontSee('Awesome');
        
        $this->factory(Course::class)->create();
        $this->factory(Section::class)->create();
        $this->factory(Activitiy::class)->create();
        $this->factory(StudentActivity::class)->create();
        
        $this->visit('Student/activities')
             ->type("1",'timeEstimated')
             ->type("1", 'timeSpent')
             ->type("Some comments on my activity", 'comments')
             ->press('Submit')
             ->seePageIs('Student/activities');
        
        $this->visit('Student/activities')
             ->type("0",'timeEstimated')
             ->type("0", 'timeSpent')
             ->type("Some more comments on my activity", 'comments')
             ->press('Submit')
             //->see(session('status'))
             ->seePageIs('Student/activities');
                
        $this->visit('Student/activities')
             ->type("800",'timeEstimated')
             ->type("800", 'timeSpent')
             ->type("Some more more comments on my activity", 'comments')
             ->press('Submit')
             ->seePageIs('Student/activities');
             //->see("Your activity has been recorded!");
    }
    
    public function testActivityFormEstimateOutOfBounds()
    {
//        $user = User::find(200);
//        
//        $user->delete();
//        
//        $Student = Role::find(3);
//        
//        $user = factory(User::class)->create();
//
//        $user->attachRole($Student);
//        
//        $this->actingAs($user)
//            ->withSession(['foo' => 'bar'])
//            ->visit('Student/activities')
//            ->see('Student Activities')
//            ->dontSee('Awesome');  
//         
//        $this->visit('Student/activities')
//             ->type("801",'timeEstimated')
//             ->type("1.0", 'timeSpent')
//             ->type("Some comments on my activity", 'comments')
//             ->press('Submit')
//             ->seePageIs('Student/activities');
           
        

//        $this->visit('Student/activities')
//             ->type("-1",'timeEstimated')
//             ->type("0.0", 'timeSpent')
//             ->type("Some more comments on my activity", 'comments')
//             ->press('Submit')
//             ->see($errors->all())
//             ->seePageIs('Student/activities');
//               
    }
    
}
