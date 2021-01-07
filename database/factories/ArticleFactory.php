<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->paragraph(1),
        'body' => $faker->text,
        'required_word_count' => rand(0, 100),
        'client_id' => factory(Client::class)->create()->id
    ];
});
