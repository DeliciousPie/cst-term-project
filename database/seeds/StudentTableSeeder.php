<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Student')->insert([
            [
                'id' => '1',
                'userID' => 'Stu001',
                'age' => 25,
                'areaOfStudy' => 'CST',
                'fName' => 'Mark',
                'lName' => 'Beitel',
                'educationalInstitution' => 'SIAST',
                'email' => 'm.beitel@test.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '2',
                'userID' => 'Stu002',
                'age' => 45,
                'areaOfStudy' => 'CST',
                'fName' => 'Jim',
                'lName' => 'Bob',
                'educationalInstitution' => 'SIAST',
                'email' => 'JamminWithJimmer@jimbo.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '3',
                'userID' => '12347',
                'age' => 22,
                'areaOfStudy' => 'CST',
                'fName' => 'David',
                'lName' => 'Dave',
                'educationalInstitution' => 'SIAST',
                'email' => 'DaringWithDave@david.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            ]);
    }
}
