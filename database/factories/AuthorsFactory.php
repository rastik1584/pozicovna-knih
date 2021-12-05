<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Authors;

$factory->define(Authors::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
    ];
});
