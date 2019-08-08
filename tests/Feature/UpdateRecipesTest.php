<?php

use App\Recipe;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UpdateRecipesTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_update_specific_recipie_fields()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('PATCH', '/api/v1/recipes/' . $recipe->id, [
            'box_type' => 'new box type',
            'recipe_cuisine' => 'new cuisine'
        ]);

        $this->assertEquals(200, $response->status());

        $content = json_decode($response->content(), true);

        $this->assertEquals([
            'box_type' => 'new box type',
            'recipe_cuisine' => 'new cuisine'
        ], $content);
    }

    /** @test */
    public function it_ignores_non_existing_fields_when_updating()
    {
        $recipe = factory(Recipe::class)->create();

        $response = $this->call('PATCH', '/api/v1/recipes/' . $recipe->id, [
            'power' => 'flying'
        ]);

        $this->assertEquals(200, $response->status()); 

        $this->assertEquals('[]', $response->content());
    }

    /** 
     * @test
     * @dataProvider validateColumnsProvider
     */
    public function it_validates_recipe_fields_when_updating($errors, $field, $value)
    {
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
