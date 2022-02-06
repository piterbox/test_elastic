<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->realText(),
        'author' => $faker->name(),
    ];
});
