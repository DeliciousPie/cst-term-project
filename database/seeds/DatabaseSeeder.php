<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           Model::unguard();

           $this->call('UserTableSeeder');
           $this->call('RoleTableSeeder');
           $this->call('sectionTypeSeeder');
           $this->call('CourseTableSeeder');
           $this->call('ProfessorTableSeeder');
           $this->call('StudentTableSeeder');
           $this->call('ActivitySeeder');
           $this->call('studentSectionSeeder');
          

           
           Model::reguard();
    }
}
