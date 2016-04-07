<?php

use Illuminate\Database\Seeder;

class ProfSectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ProfSection')->insert([
            [
                'userID' => 'Pro001',
                'sectionID' => '1',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ], 
            [
                'userID' => 'Pro002',
                'sectionID' => '1',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'userID' => 'Pro002',
                'sectionID' => '2',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'userID' => 'Pro002',
                'sectionID' => 'a',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            ]);
    }
}
