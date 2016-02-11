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
