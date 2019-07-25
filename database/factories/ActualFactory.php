<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Actual;
use App\Plan;
use App\ActualCategory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Actual::class, function (Faker $faker) {
    $plan = Plan::all()->random();
    return [
        'title' => $faker->sentence($nbWords = 2),
        'description' => $faker->sentence($nbWords = 5),
        'plan_id' => $plan->id,
        'code' => Str::random(10),
        'color' => $faker->hexcolor,
        'actual_date_start' => $faker->dateTimeBetween($startDate = $plan->start, $endDate = $plan->end),
        'actual_date_end' => $faker->dateTimeBetween($startDate = $plan->start, $endDate = $plan->end),
        'user_id' => App\User::all()->random()->id,
        'actual_category_id' => ActualCategory::all()->random()->id
    ];
});
