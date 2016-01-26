<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Justin Lutzko',
                'userID' => '12345',
                'email' => 'justin.lutzko@hotmail.ca',
                'password' => bcrypt('password'),
                'created_at'       => new DateTime,
                'updated_at'       => new DateTime,
            ], 
            [
                'name' => 'Mark Beitel',
                'userID' => 'adm219',
                'email' => 'beitel9933@saskpolytech.ca',
                'password' => bcrypt('password'),
                'created_at'       => new DateTime,
                'updated_at'       => new DateTime,
            ], 
            [
                'name' => 'Nathan',
                'userID' => '12346',
                'email' => 'nathan@email.com',
                'password' => bcrypt('password'),
                'created_at'       => new DateTime,
                'updated_at'       => new DateTime,
            ],
            [
                'name' => 'David',
                'userID' => '12347',
                'email' => 'david@email.com',
                'password' => bcrypt('password'),
                'created_at'       => new DateTime,
                'updated_at'       => new DateTime,

            ],
            [
                'name' => 'Lisa',
                'userID' => '12348',
                'email' => 'lisa@email.com',
                'password' => bcrypt('password'),
                'created_at'       => new DateTime,
                'updated_at'       => new DateTime,
            ],
            ]);
    }
}
