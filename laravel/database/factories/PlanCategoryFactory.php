<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\PlanCategory;
use Faker\Generator as Faker;

$factory->define(PlanCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence($nbWords = 5)
    ];
});
