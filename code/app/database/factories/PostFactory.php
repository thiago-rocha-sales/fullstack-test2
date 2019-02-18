<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    $authors = App\Author::pluck('id')->toArray();

    $imagePath = storage_path('images');

    if(!File::exists($imagePath)) {
        File::makeDirectory($imagePath);
    }

    return [
        'title' => $faker->sentence(6, true),
        'slug' => $faker->slug,
        'body' => $faker->text(500),
        'image' => $faker->image($imagePath, 400, 300, null, false),
        'published' => $faker->boolean(),
        'author_id' => $faker->randomElement($authors)
    ];
});
