<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\Section;

class studentSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('StudentSection')->insert([
            [
                'userID' => '12347',
                'sectionID' => '1',
            ],
            [
                
                'userID' => '12347',
                'sectionID' => '3',  
            ]
            
            ]); 
        

        
        
        
    }
}
