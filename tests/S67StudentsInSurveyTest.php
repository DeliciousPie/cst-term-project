<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Activity;
use App\Http\Controllers\CD\ActivityManagerController;
use Illuminate\Support\Facades\Artisan;
use App\User;
use App\CD;
use App\Role;

class S67StudentsInSurveyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        //Reset the database
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed'); 
        
        // Create an Activty Manager Controller object
        $AMC = new ActivityManagerController();
               
        //Add the BUS182 class into the database
        DB::table('Section')->insert([
                'sectionID' => 'BUS182.1',
                'sectionType' => '1',
                'courseID' => "BUS182",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                ]);
        
        $this->seeInDatabase('Section',
        [
            'sectionID' => "BUS182.1"
        ]); 
        
        //Insert an entry for that professor in the ProfessorSection table.
        DB::table('ProfessorSection')->insert([
                'sectionID' => 'BUS182.1',
                'userID' => 'Pro002',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                ]);
        
        $this->seeInDatabase('ProfessorSection',
        [
            'sectionID' => "BUS182.1",
            'userID' => 'Pro002'
        ]); 
        //Add in an entry into student section
        DB::table('StudentSection')->insert([
            'userID' => 'Stu001',
            'sectionID' => 'BUS182.1',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
            ]);
        
        DB::table('StudentSection')->insert([
            'userID' => 'Stu002',
            'sectionID' => 'BUS182.1',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
            ]);
        
        $this->seeInDatabase('StudentSection',
        [
            'userID' => 'Stu001',
            'sectionID' => "BUS182.1"
        ]);
        
        $this->seeInDatabase('StudentSection',
        [
            'userID' => 'Stu002',
            'sectionID' => "BUS182.1"
        ]); 
        
        //Add an activity in
        $_POST = ['activityName' => 'S67Activity',
                    'activityID' => 20,
                    'startDate' => '2050-01-01',
                    'dueDate' => '2051-01-01', 
                    'workload' => '3',
                    'stresstimate' => '3',
                    'profID' => 'Pro011',
                    'courseID' => 'BUS182.1'];
            
        $AMC->addActivity();

        // Assert that the Activity added is actually in the database
        $this->seeInDatabase('Activity',
        [
            'activityType' => 'S67Activity',
            'sectionID' => 'BUS182.1'
        ]);
        
        //Assert that the Activity has also been added to the StudentActivity table
        $this->seeInDatabase('StudentActivity',
        [
            'activityID' => 20,
            'userID' => 'Stu001',
            
        ]);
        
        $this->seeInDatabase('StudentActivity',
        [
            'activityID' => 20,
            'userID' => 'Stu002',
            
        ]);
        
        
        
    }
}
