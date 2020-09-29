<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DmsCategory;
use Faker\Generator as Faker;

$factory->define(DmsCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
    ];
});
