<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Recipe $recipe, Request $request)
    {
        $params = $request->all();

        $results = $recipe->filter($params)->paginate(10);

        if ( count($results->items() > 10) ) {
            return response()->json($results, 206);
        }

        return $results;
    }    

    public function show($id, Recipe $recipe)
    {
        return $recipe->findOrFail($id);
    }

    public function update($id, Recipe $recipe, Request $request)
    {
        $recipe->findOrFail($id)->update($request->all());

        $fields = array_keys($request->all());

        return response()->json([
            $recipe->select($fields)->get()
        ], 200);
    }
}
