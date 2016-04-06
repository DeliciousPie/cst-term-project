<?php

use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Course')->insert([
            [
                'courseID' => 'BUS182',
                'areaOfStudy' => 'CST',
                'courseName' => 'Business Principles',
            ], 
            [
                'courseID' => 'CDBM190',
                'areaOfStudy' => 'CST',
                'courseName' => 'Introduction to Database Management',
            ],
            [
                'courseID' => 'CDBM280',
                'areaOfStudy' => 'CST',
                'courseName' => 'Database Management Systems',
            ],   
            [
                'courseID' => 'CNET184',
                'areaOfStudy' => 'CST',
                'courseName' => 'Data Communications and Networking 1',
            ],
            [
                'courseID' => 'CNET190',
                'areaOfStudy' => 'CST',
                'courseName' => 'Network Administration 1',
            ], 
            [
                'courseID' => 'CNET280',
                'areaOfStudy' => 'CST',
                'courseName' => 'Data Communications and Networking 2',
            ], 
            [
                'courseID' => 'CNET293',
                'areaOfStudy' => 'CST',
                'courseName' => 'Network Administration 2',
            ],   
            [
                'courseID' => 'CNET295',
                'areaOfStudy' => 'CST',
                'courseName' => 'Directory Services',
            ], 
            [
                'courseID' => 'COAP173',
                'areaOfStudy' => 'CST',
                'courseName' => 'Data and Document Management',
            ], 
            [
                'courseID' => 'COET295',
                'areaOfStudy' => 'CST',
                'courseName' => 'Emerging Technologies',
            ], 
            [
                'courseID' => 'COHS190',
                'areaOfStudy' => 'CST',
                'courseName' => 'Hardware',
            ],   
            [
                'courseID' => 'COHS280',
                'areaOfStudy' => 'CST',
                'courseName' => 'Service and Support',
            ],             
            
            ]);
    }
}
