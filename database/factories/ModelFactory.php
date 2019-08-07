<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Recipe::class, function (Faker $faker) {

	$box_types = ['vegetarian', 'gourmet'];

	$cuisines = ['asian', 'italian', 'british', 'mediterranean', 'mexican'];

	$diet_type_id = ['meat', 'fish', 'vegetarian'];

	$title = $faker->title;

    return [
        'box_type' => $box_types[array_rand($box_types, 1)],
        'title' => $title,
        'slug' => str_slug($title, '-'),
        'short_title' => '',
        'marketing_description' => $faker->paragraph,
        'calories_kcal' => rand(350, 550),
        'protein_grams' => rand(10, 15),
        'fat_grams' => rand(30,45),
        'carbs_grams' => 0,
        'bulletpoint1' => '',
        'bulletpoint2' => '',
        'bulletpoint3' => '',
        'recipe_diet_type_id' => $diet_type_id[array_rand($diet_type_id, 1)],
        'season' => 'all',
        'base' => 'noodles',
        'protein_source' => 'beef',
        'preparation_time_minutes' => rand(30,50),
        'shelf_life_days' => rand(2,7),
        'equipment_needed' => 'Appetite, ' . str_random(10),
        'origin_country' => 'Great Britain',
        'recipe_cuisine' => $cuisines[array_rand($cuisines, 1)],
        'in_your_box' => '',
        'gousto_reference' => rand(1,1000)
    ];
});