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
        'name' => $faker->name,
        'email' => $faker->email,
        'userID' => "" . $faker->numberBetween(0, 100000),
        'password' => bcrypt('password'),
        'confirmed' => 1,
        'remember_token' => str_random(10),
    ];
});



//Create a fake course
$factory->define(App\Course::class, function (Faker\Generator $faker) {
        return[
                'courseID' => "COSC" . $faker->numberBetween(100, 999),
                'areaOfStudy' => 'CST',
                'courseName' => $faker->text(10),
                'description' => $faker->text(10),
            ];
});

//Create a fake Section
$factory->define(App\Section::class, function (Faker\Generator $faker) {

        return [ 
            'sectionID' => $faker->text(5),
            'courseID' => function(){
                return factory(App\Course::class)->create()->courseID;
            },
            'date' => $faker->date = new DateTime,
        ];
});

//Create a fake Activity
$factory->define(App\Activity::class, function (Faker\Generator $faker) {
    
        return [ 
           
            'sectionID' => function(){
                return factory(App\Section::class)->create()->sectionID;
            },
            'activityType' => 'Assignment',
            'assignDate' => $faker->assignDate = new DateTime,
            'dueDate' => $faker->dueDate = new DateTime,
            'estTime' => $faker->numberBetween(0, 40),
            'stresstimate' => $faker->numberBetween(0, 10),
        ];
    
});

//Create a fake Student Activity.
$factory->define(App\StudentActivity::class, function (Faker\Generator $faker) {
    return [
        'userID' => function() {
            return factory(App\User::class)->create()->userID;
        },
        'activityID' => "3",
        'timespent' => $faker->numberBetween(0, 40),
        'stressLevel' => $faker->numberBetween(0, 10),
        'comments' => $faker->text(30),
        'timeEstimated' => $faker->numberBetween(0, 40),
        'submitted' => 1,
    ];
});


//Create a fake Student.
$factory->define(App\Student::class, function (Faker\Generator $faker) {    
    return [
       
        'userID' => function(){
            return factory(App\User::class)->create()->userID;

        },
        'age' => $faker->numberBetween(18, 70),
        'areaOfStudy' => 'CST',
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'educationalInstitution' => $faker->text(10),
        'email' => $faker->email,
    ];
});

$factory->define(App\StudentSection::class, function (Faker\Generator $faker) {    
    return [
        'userID' => $faker->numberBetween(0, 100000),
        'sectionID' => "3"
    ];
});


