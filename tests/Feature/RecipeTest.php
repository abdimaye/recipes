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
        
        $this->seeJson([
            'box_type' => $recipe->box_type
        ]);
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
}
