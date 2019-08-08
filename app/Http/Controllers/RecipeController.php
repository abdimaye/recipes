<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    /**
     * Display paginated recipes by filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function index(Recipe $recipe, Request $request)
    {
        $params = $request->all();

        unset($params['page']);

        $results = $recipe->filter($params)->paginate(10);

        if ( count($results->items() > 10) ) {
            return response()->json($results, 206);
        }

        return $results;
    }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show($id, Recipe $recipe)
    {
        return $recipe->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int $id
     * @param  \App\Recipe  $recipe
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Recipe $recipe, Request $request)
    {
        $this->validate($request, [
            'box_type' => 'string|min:3',
            'title' => 'string|min:3',
            'short_title' => 'nullable|string',
            'marketing_description' => 'string|min:3',
            'calories_kcal' => 'integer|min:0',
            'protein_grams' => 'integer|min:0',
            'fat_grams' => 'integer|min:0',
            'carbs_grams' => 'integer|min:0',
            'recipe_diet_type_id' => 'string|min:3',
            'season' => 'string|min:3',
            'base' => 'nullable|string',
            'protein_source' => 'string|min:3',
            'preparation_time_minutes' => 'integer|min:0',
            'shelf_life_days' => 'integer|min:0',
            'equipment_needed' => 'string|min:3',
            'origin_country' => 'string|min:2',
            'recipe_cuisine' => 'string|min:3',
            'gousto_reference' => 'integer|min:0'
        ]);
        
        $recipe->findOrFail($id)->update($request->all());

        $fields = array_keys($request->all());

        return response()->json([
            $recipe->select($fields)->get()
        ], 200);
    }
}
