<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ActualCategory;
use Faker\Generator as Faker;

$factory->define(ActualCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence($nbWords = 5)
    ];
});
