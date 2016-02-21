<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            [
                'name' => 'Justin Lutzko',
                'userID' => '12345',
                'email' => 'justin.lutzko@hotmail.ca',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Mark Beitel',
                'userID' => 'adm219',
                'email' => 'beitel9933@saskpolytech.ca',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Nathan',
                'userID' => '12346',
                'email' => 'nathan@email.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'David',
                'userID' => '12347',
                'email' => 'david@email.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Lisa',
                'userID' => '12348',
                'email' => 'lisa@email.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Mark Bietel',
                'userID' => 'Pro001',
                'email' => 'm.b@test.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Tim Jim',
                'userID' => 'Pro002',
                'email' => 'timmer.jimmer@timjim.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Magan Heinlen',
                'userID' => 'Pro003',
                'email' => 'M.Heinlein008@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Cristin Gilder',
                'userID' => 'Pro005',
                'email' => 'C.Gilder009@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Len Crouch',
                'userID' => 'Pro004',
                'email' => 'L.Crouch011@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Alysa Burroughs',
                'userID' => 'Pro006',
                'email' => 'A.Burroughs010@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Ashley Giron',
                'userID' => 'Pro007',
                'email' => 'A.Giron012@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Heath Wilker',
                'userID' => 'Pro008',
                'email' => 'H.Wilker013@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Joseph Sprang',
                'userID' => 'Pro009',
                'email' => 'J.Spang014@SIAST.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Mark Bietel',
                'userID' => 'Stu001',
                'email' => 'm.beitel@test.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Jim Bob',
                'userID' => 'Stu002',
                'email' => 'JamminWithJimmer@jimbo.com',
                'password' => bcrypt('password'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
        ]);
    }

}
