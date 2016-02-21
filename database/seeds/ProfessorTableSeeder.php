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
            ], 
            [
                'id' => '3',
                'userID' => 'Pro003',
                'fName' => 'Magan',
                'lName' => 'Heinlein',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'M.Heinlein008@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '4',
                'userID' => 'Pro004',
                'fName' => 'Len',
                'lName' => 'Crouch',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'L.Crouch011@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '5',
                'userID' => 'Pro005',
                'fName' => 'Cristin',
                'lName' => 'Gilder',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'C.Gilder009@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '6',
                'userID' => 'Pro006',
                'fName' => 'Alysa',
                'lName' => 'Burroughs',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'A.Burroughs010@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '7',
                'userID' => 'Pro007',
                'fName' => 'Ashely',
                'lName' => 'Giron',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'A.Giron012@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '8',
                'userID' => 'Pro008',
                'fName' => 'Heath',
                'lName' => 'Wilker',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'H.Wilker013@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'id' => '9',
                'userID' => 'Pro009',
                'fName' => 'Joseph',
                'lName' => 'Spang',
                'educationalInstitution' => 'SIAST',
                'areaOfStudy' => 'CST',
                'email' => 'J.Spang014@SIAST.com',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            ]);
    }
}
