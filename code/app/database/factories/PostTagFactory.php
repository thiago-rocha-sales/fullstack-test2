<?php

use Faker\Generator as Faker;

$factory->define(App\PostTag::class, function (Faker $faker) {
    $posts = App\Post::pluck('id')->toArray();
    $tags = App\Tag::pluck('id')->toArray();

    return [
        'post_id' => $faker->randomElement($posts),
        'tag_id' => $faker->randomElement($tags)
    ];
});
