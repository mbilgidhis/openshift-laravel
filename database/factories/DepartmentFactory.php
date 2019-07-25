<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence($nbWords = 5)
    ];
});
