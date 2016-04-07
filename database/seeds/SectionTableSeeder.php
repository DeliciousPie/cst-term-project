<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Section')->insert([
            [
                'sectionID' => '1',
                'sectionType' => '1',
                'courseID' => "BUS182",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'sectionID' => '2',
                'sectionType' => '2',
                'courseID' => "CDBM190",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '9',
                'sectionType' => '3',
                'courseID' => "CDBM280",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '3',
                'sectionType' => 'a',
                'courseID' => "CDBM180",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '4',
                'sectionType' => 'b',
                'courseID' => "CNET184",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '5',
                'sectionType' => 'c',
                'courseID' => "CNET280",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '6',
                'sectionType' => '1',
                'courseID' => "CNET293",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '7',
                'sectionType' => '2',
                'courseID' => "COAP173",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '8',
                'sectionType' => '3',
                'courseID' => "CNET295",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'sectionID' => '9',
                'sectionType' => 'a',
                'courseID' => "COHS280",
                'date' => new DateTime,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            ]);
    }
}
