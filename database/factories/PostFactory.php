<?php

use Ubuntu\Press\Post;
use Illuminate\Support\Str;

$factory->define(Post::class, function(Faker\Generator $faker){
    return [
        'identifier' => Str::random(32),
        'slug' => Str::slug($faker->sentence),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'extra' => json_encode(['test' => 'value']),
    ];
});