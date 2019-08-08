<?php

namespace Tests\Unit;

use App\Recipe;
use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RecipeTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
    public function can_get_filtered_recipes()
    {
    	$base = str_random(10);

        factory(Recipe::class, 11)->create([
            'base' => $base,
            'season' => 'spring'
        ]);

        factory(Recipe::class, 100)->create();

        $filter = Recipe::filter([
        	'base' => $base,
        	'season' => 'spring'
        ]);

        $this->assertEquals( 11, count($filter->get()) );
    }
}
