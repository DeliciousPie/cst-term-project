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
            'proffEstimate' => 2.0,
            'cdAlocatedTime' => 2.0,
            'comments' => "Student better get it done.",
        ]);
        
        DB::table('StudentActivity')->insert([
            'userID' => '12347',
            'activityID' => 1
        ]);
        
        DB::table('Activity')->insert([
            'activityID' => 2,
            'sectionID' => 1,
            'activityType' => 'Assignment2',
            'assignDate' => new DateTime,
            'dueDate' => new DateTime,
            'estTime' => 700.0,
            'proffEstimate' => 500.0,
            'cdAlocatedTime' => 500.0,
            'comments' => "ETA 2020",
        ]);
        
        DB::table('StudentActivity')->insert([
            'userID' => '12347',
            'activityID' => 2
        ]);
    }
}