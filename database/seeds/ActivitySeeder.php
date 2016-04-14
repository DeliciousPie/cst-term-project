<?php

use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('Course')->insert([
                
                'courseID' => 'COMM101',
                'courseName' => 'Intro to Business',
                'description' => 'Learn about business.',
            ]);
        
        DB::table('Section')->insert([
            'sectionID' => 1,
            'courseID' => 'COMM101',
            'date' => new DateTime,
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 1,
            'sectionID' => 1,
            'activityType' => 'Assignment',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 2.0,
            'stresstimate' => 4,
        ]);
        
        DB::table('StudentActivity')->insert([
            'userID' => '12347',
            'activityID' => 1,
            'timeSpent' => 5,
            'stressLevel' => 5,
            'comments' => '',
            'timeEstimated' => 6,
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 2,
            'sectionID' => 1,
            'activityType' => 'Assignment2',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 700.0,
            'stresstimate' => 4,
        ]);
        
        DB::table('StudentActivity')->insert([
            'userID' => '12347',
            'activityID' => 2,
            'timeSpent' => 21,
            'stressLevel' => 7,
            'comments' => '',
            'timeEstimated' => 15,
        ]);
        
        DB::table('Course')->insert([
                
            'courseID' => 'COMM210',
            'courseName' => 'Accounting',
            'description' => 'Learn about business.',
        ]);
        
        DB::table('Section')->insert([
            'sectionID' => 3,
            'courseID' => 'COMM210',
            'date' => new DateTime,
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 3,
            'sectionID' => 3,
            'activityType' => 'Assignment3',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 2.0,
            'stresstimate' => 4,
        ]);
        
        DB::table('StudentActivity')->insert([
            'userID' => '12347',
            'activityID' => 3,
            'timeSpent' => 12,
            'stressLevel' => 7,
            'comments' => '',
            'timeEstimated' => 14,
        ]);
        
         DB::table('Course')->insert([
                
                'courseID' => 'COSA110',
                'courseName' => 'Intro to Projects',
                'description' => 'Learn about projects!',
            ]);
        
        DB::table('Section')->insert([
            'sectionID' => 'COSA110.5',
            'courseID' => 'COSA110',
            'date' => new DateTime,
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 15,
            'sectionID' => 'COSA110.5',
            'activityType' => 'AssignmentTest',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 2.0,
            'stresstimate' => 4,
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 16,
            'sectionID' => 'COSA110.5',
            'activityType' => 'Midterm 1',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 3.0,
            'stresstimate' => 9,
        ]);
                
        DB::table('Activity')->insert([
            'activityID' => 17,
            'sectionID' => 'COSA110.5',
            'activityType' => 'Assignment 2',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 55,
            'stresstimate' => 6,
        ]);
        
        DB::table('ProfessorSection')->insert([
            'sectionID' => 'COSA110.5',
            'userID' => 'Pro002',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('users')->insert([
            
            'id' => 200000,
            'name' => "Dallen",
            'email' => "Dallen@mail.com",
            'userID' => "696969",
            'password' => bcrypt(str_random(10)),
            'confirmed' => true,
            'remember_token' => str_random(10),
        ]);
        
        DB::table('Course')->insert([
                
                'courseID' => 'COMM102',
                'courseName' => 'Intro to Business',
                'description' => 'Learn about business',
            ]);
        
        DB::table('Section')->insert([
            'sectionID' => 199000,
            'courseID' => 'COMM102',
            'date' => new DateTime,
        ]);
        
        DB::table('Activity')->insert([
            
            'activityID' => 199000,
            'sectionID' => 199000,
            'activityType' => 'AssignmentTest',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 2.0,
        ]);
        

        
        DB::table('StudentActivity')->insert([
            
            'userID' => "696969",
            'activityID' => 199000,
            'timespent' => 1,
            'stressLevel' => 2,
            'comments' => "Test",
            'timeEstimated' => 3,
            'submitted' => 1,
        ]);

       
        
        
    }
}
