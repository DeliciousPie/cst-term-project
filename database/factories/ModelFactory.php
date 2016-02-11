<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//Create a fake user.
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->id = 200000,
        'name' => $faker->name = "Dallen",
        'email' => $faker->email = "Dallen@mail.com",
        'userID' => $faker->userID = "696969",
        'password' => bcrypt(str_random(10)),
        'confirmed' => $faker->confirmed = true,
        'remember_token' => str_random(10),
    ];
});



//Create a fake course
$factory->define(App\Course::class, function (Faker\Generator $faker) {
        return[
                'courseID' => $faker->courseID = 'COMM102',
                'courseName' => $faker->courseName = 'Intro to Business',
                'description' => $faker->description = 'Learn about business.',
            ];
});

//Create a fake Section
$factory->define(App\Section::class, function (Faker\Generator $faker) {

        return [ 
            'sectionID' => $faker->sectionId = 199000,
            'courseID' => $faker->courseID = 'COMM102',
            'date' => $faker->date = new DateTime,
        ];
});

//Create a fake Activity
$factory->define(App\Activity::class, function (Faker\Generator $faker) {
    
        return [ 
            'activityID' => $faker->activityID = 199000,
            'sectionID' => $faker->sectionID = 199000,
            'activityType' => $faker->activityType = 'AssignmentTest',
            'assignDate' => $faker->assignDate = new DateTime,
            'dueDate' => $faker->dueDate = new DateTime,
            'estTime' => $faker->estTime = 2.0,
            'proffEstimate' => $faker->profEstimate = 2.0,
            'cdAlocatedTime' => $faker->cdAlocatedTime = 2.0,
            'comments' => "Student better get it done.",
        ];
    
});

//Create a fake Student Activity.
$factory->define(App\StudentActivity::class, function (Faker\Generator $faker) {
    return [
        'userID' => $faker->userID = "696969",
        'activityID' => $faker->activityID = 199000,
        'timespent' => $faker->timespent = 1,
        'stressLevel' => $faker->stressLevel = 2,
        'comments' => $faker->comments = "Test",
        'timeEstimated' => $faker->timeEstimated = 3,
        'submitted' => $faker->submitted = 1,
    ];
});


//Create a fake Student.
$factory->define(App\Student::class, function (Faker\Generator $faker) {    
    return [
        'id' => $faker->id = 200,
        'userID' => $faker->userID = "696969",
        'name' => $faker->name = "Dallen",      
        'email' => $faker->email = "Dallen@mail.com",
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});