<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Authors;
use App\Books;
use Faker\Generator as Faker;

$factory->define(Books::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'is_borrowed' => $faker->boolean,
        'author_id' => factory(Authors::class)
    ];
});
