<?php

use App\Recipe;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ViewRecipesTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_recipe_by_id()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('GET', '/api/v1/recipes/' . $recipe->id);
        
        $this->assertEquals(200, $response->status());

        $content = json_decode($response->content(), true);

        $this->assertEquals($recipe->toArray(), $content);
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
    public function it_returns_404_when_recipe_does_not_exist()
    {
        $response = $this->call('GET', '/api/v1/recipes/does-not-exist');
        
        $this->assertEquals(404, $response->status());

        $this->seeJson([
            'error' => 'Resource not found'
        ]); 
    }
}
