<?php

use App\Recipe;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class FilterTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_paginated_results_by_cuisine()
    {
        $cuisine = str_random(10);

        $recipe = factory(Recipe::class, 40)->create([
            'recipe_cuisine' => $cuisine
        ]);

        $query = sprintf("?recipe_cuisine=%s", $cuisine);

        $response = $this->call('GET', '/api/v1/recipes' . $query);
        
        $content = json_decode($response->getContent());

        $this->assertEquals(206, $response->status());
        
        $this->seeJson([
            'current_page' => 1,
            'per_page' => 10,
            'prev_page_url' => null,
            'total' => 40
        ]);

        $this->assertEquals(10, count($content->data));
    }

    /**
     * @test
     * 
     * Returned fields should be ID, title and description
     */
    public function it_will_only_return_specific_fields()
    {
        $recipe = factory(Recipe::class, 10)->create();

        $response = $this->call('GET', '/api/v1/recipes');
        
        $content = json_decode($response->getContent(), true);

        $fields = array_keys($content['data'][0]);

        $this->assertEquals(['id', 'title' ,'marketing_description'], $fields);
    }
}
