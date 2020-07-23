<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Call::class, function (Faker $faker) {
    return [
        'callerID' => $faker->phoneNumber,
    ];
});
