<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'email'=>$faker->unique()->email,
        'password'=>$faker->password,
        'phone'=>$faker->numerify('5########')
    ];
});
