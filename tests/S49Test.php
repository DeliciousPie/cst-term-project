<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\CD\CDQueryController;
use App\User;
use App\Role;
use App\Course;

/**
 * Purpose: The purpose this unit test is to test the Bubblechart story.
 */
class S49Test extends TestCase
{
 /**
     * Purpose: 
     * 
     * @author Justin Lutzko
     * 
     * @date Feb 21 2016
     * 
     */
//    public function testViewBubbleChart()
//    {
//        
//        $this->baseUrl = 'http://phpserver/CD';
//         //Find user with id 200000
//        $user = User::find(200000);
//        
//        //If the user exists, delete it
//        if( $user != null )
//        {
//           $user->delete(); 
//        }
//        
//        //Get student roles from db
//        $CD = Role::find(1);
//        
//        $user = factory(User::class)->create([
//                'id' => 200000,
//                'name' => "Dallen",
//                'email' => "Dallen@mail.com",
//                'userID' => "696969",
//                'password' => bcrypt(str_random(10)),
//                'confirmed' => true,
//                'remember_token' => str_random(10),
//        ]);
//
//        
//        //Attach the student role to the user.
//        $user->attachRole($CD);
//        
//        //Look on the page too see if we can find the fake student activity.
//        $this->actingAs($user)
//             ->withSession(['foo' => 'bar'])
//             ->visit('/dashboard')
//             ->select("4", 'chartSelected')
//             ->see('Welcome Dallen!')
//             ->see('Please select courses')
//             ->see('CNET280')
//             ->see('COSA110')
//             ->select('COMM210')
//             ->press('studentRight')
//             ->see('Please select students')
//             ->see('COMM210')
//             ->press('studentRightAll')
//             ->see('Parameter 1:')
//             ->select('stressLevel', 'comparison1')
//             ->see('Parameter 2:')
//             ->select('timeSpent', 'comparison2')
//             ->see('Bubble Radius:')
//             ->select('timeEstimated', 'comparison3')
//             ->see('Submit')
//             //this should not be on the page
//             ->dontSee('Awesome') 
//             //Submit form
//             ->press('Submit')
//             ->seePageIs('/dashboard');
//
//        
//    }
    
    /**
     * Purpose: The purpose of this unit test is to pass of the possible data
     * from the fields and get results back.
     * 
     */
    public function testSubmitAllCoursesAndUsers()
    {
        $this->withoutMiddleware();
        
        $this->baseUrl = 'http://phpserver/CD';
        
        $user = $this->createUser();
    
        $courses = Course::all();
        
        $this->actingAs($user)
             ->call('POST', '/dashboard',
                ['chartSelected' => "4",
                 'courseList' => $courses->all()->courseID,
                 'studentList' => [        
                    0 => "COMM210, 10299",
                    1 => "COMM210, 24544",
                    2 => "COMM210, 26487",
                    3 => "COMM210, 29463",
                    4 => "COMM210, 30502",
                    5 => "COMM210, 3178",
                    6 => "COMM210, 65416",
                    7 => "COMM210, 69529",
                    8 => "COMM210, 75542",
                    9 => "COMM210, 82432"],   
                 'comparison1' => "stressLevel" , 
                 'comparison2' => "timeSpent",
                 'comparison3' => "timeEstimated"]);
        $this->see('Average Time Actual, Stress Level And Time Actual')
             ->see(20.5)
             ->see(4.3)
             ->dontSee(11.6666); 
    }
}
