<?php

use App\Model\Profession;
use Faker\Generator as Faker;

$factory->define(Profession::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3, false)
    ];
});
