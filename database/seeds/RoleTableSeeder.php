<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
       
                $CD = new Role();
                $CD->name = 'CD';
                $CD->save();
                
                $Prof = new Role();
                $Prof->name = 'Prof';
                $Prof->save();
                
                $Student = new Role();
                $Student->name = 'Student';
                $Student->save();
                
                $user = User::find(1);
                $user->attachRole($CD);
                
                $user = User::find(2);
                $user->attachRole($Prof);
                
                $user = User::find(3);
                $user->attachRole($Student);
                
                $user = User::find(4);
                $user->attachRole($Student);
           
    }
}
