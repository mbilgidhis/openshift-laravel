<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Plan;
use App\User;
use App\PlanCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Plan::class, function (Faker $faker) {
    $date = $faker->dateTimeBetween($startDate = date('Y-m-01'), $endDate = date('Y-m-14'));
    return [
        'title' => $faker->sentence($nbWords = 3),
        'description' => $faker->sentence($nbWords = 5),
        'start' => $date,
        'end' => $faker->dateTimeBetween($startDate = Carbon::parse($date)->addDays(1), $endDate = Carbon::parse($date)->addDays(4)),
        'color' => $faker->hexcolor,
        'code' => Str::random(10),
        'plan_category_id' => PlanCategory::all()->random()->id,
        'created_by' => User::where('email', 'super@andibasko.ro')->first()->id,
        'user_id' => User::all()->random()->id,
        'status' => $faker->word
    ];
});
