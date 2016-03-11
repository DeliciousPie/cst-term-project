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
    }
}
