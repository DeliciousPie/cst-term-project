<?php

use Illuminate\Database\Seeder;

class ProfessorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('Professor')->insert([
            [
                'id' => '1',
                'userID' => 'Pro001',
                'fName' => 'Mark',
                'lName' => 'Beitel',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'm.b@test.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '2',
                'userID' => 'Pro002',
                'fName' => 'Tim',
                'lName' => 'Jim',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'timmer.jimmer@timjim.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]
            ]);
    }
}
