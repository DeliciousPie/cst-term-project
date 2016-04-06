<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('Activity')->insert([
            [
                'activityID' => '1',
                'sectionID' => '1',
                'activityType' => 'Assignment1',
                'assignDate' => new DateTime,
                'dueDate' => new DateTime,
                'estTime' => 18,
                'stresstimate' => '5',
            ],
            [
                'activityID' => '2',
                'sectionID' => '2',
                'activityType' => 'Assignment2',
                'assignDate' => new DateTime,
                'dueDate' => new DateTime,
                'estTime' => 12,
                'stresstimate' => '6',
            ],
            [
                'activityID' => '8',
                'sectionID' => '2',
                'activityType' => 'Midterm',
                'assignDate' => new DateTime,
                'dueDate' => new DateTime,
                'estTime' => 4,
                'stresstimate' => '9',
            ],
            [
                'activityID' => '6',
                'sectionID' => '2',
                'activityType' => 'Midterm2',
                'assignDate' => new DateTime,
                'dueDate' => new DateTime,
                'estTime' => 15,
                'stresstimate' => '5',
            ],
            [
                'activityID' => '4',
                'sectionID' => '4',
                'activityType' => 'Final',
                'assignDate' => new DateTime,
                'dueDate' => new DateTime,
                'estTime' => 26,
                'stresstimate' => '10',
            ],
        ]);
    }

}
