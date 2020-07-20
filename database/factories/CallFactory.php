<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\calls::class, function (Faker $faker) {
    return [
        'callerID' => $faker->phoneNumber,
    ];
});
