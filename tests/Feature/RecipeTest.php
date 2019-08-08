<?php

use App\Recipe;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipeTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_recipe_by_id()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('GET', '/api/v1/recipes/' . $recipe->id);
        
        $this->assertEquals(200, $response->status());

        $content = json_decode($response->content(), true);

        $this->assertEquals($content, $recipe->toArray());
    }

    /** @test */
    public function can_view_all_recipes_as_paginated_results()
    {
        $recipe = factory(Recipe::class, 99)->create();

        $query = '?page=10';

        $response = $this->call('GET', '/api/v1/recipes' . $query);
        
        $content = json_decode($response->getContent());

        $this->assertEquals(206, $response->status());
        
        $this->seeJson([
            'current_page' => 10,
            'per_page' => 10,
            'total' => 99
        ]);

        // the last page should only have 9 results
        $this->assertEquals(9, count($content->data));        
    }

    /** @test */
    public function can_update_specific_recipie_fields()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('PATCH', '/api/v1/recipes/' . $recipe->id, [
            'box_type' => 'new box type',
            'recipe_cuisine' => 'new cuisine'
        ]);

        $this->assertEquals(200, $response->status());
        
        $this->seeJson([
            'box_type' => 'new box type',
            'recipe_cuisine' => 'new cuisine'
        ]);
    }

    /** 
     * @test
     * @dataProvider validateColumnsProvider
     */
    public function it_validates_recipe_fields_when_updating($errors, $field, $value)
    {
        // dd($errors);
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('PATCH', '/api/v1/recipes/' . $recipe->id, [
            $field => $value
        ]);

        $this->assertEquals(422, $response->status());
        
        $this->seeJson([
            $field => $errors
        ]);
    }

    public function validateColumnsProvider()
    {
        return [
            [
                ['The box type must be a string.', 'The box type must be at least 3 characters.'], 
                'box_type',
                null
            ],
            [
                ['The title must be a string.', 'The title must be at least 3 characters.'], 
                'title',
                2
            ],
            [
                ['The marketing description must be at least 3 characters.'], 
                'marketing_description',
                'ab'
            ],
            [
                ['The calories kcal must be an integer.'], 
                'calories_kcal',
                'one hundred'
            ],
            [
                ['The protein grams must be an integer.'], 
                'protein_grams',
                null
            ],
            [
                ['The fat grams must be at least 0.'], 
                'fat_grams',
                -1
            ],
            [
                ['The carbs grams must be at least 0.'], 
                'carbs_grams',
                -1
            ],
            [
                ['The recipe diet type id must be a string.', 'The recipe diet type id must be at least 3 characters.'], 
                'recipe_diet_type_id',
                -1
            ],
        ];
    }
}
