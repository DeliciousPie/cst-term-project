<?php

use Illuminate\Database\Seeder;
use App\SectionType; 

class sectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SectionType::create([
                    'sectionID' => 'a',
                    'description' => ''
                ]);
        SectionType::create([
                    'sectionID' => 'b',
                    'description' => ''
                ]);
        SectionType::create([
                    'sectionID' => 'c',
                    'description' => ''
                ]);
        SectionType::create([
                    'sectionID' => '1',
                    'description' => ''
                ]);
        SectionType::create([
                    'sectionID' => '2',
                    'description' => ''
                ]);
        SectionType::create([
                    'sectionID' => '3',
                    'description' => ''
                ]);
    }
}
