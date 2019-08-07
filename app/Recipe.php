<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'box_type', 'title', 'short_title', 'marketing_description', 'calories_kcal', 'protein_grams' ,'fat_grams', 'carbs_grams', 
    	'bulletpoint1', 'bulletpoint2', 'bulletpoint3', 'recipe_diet_type_id', 'season', 'base', 'protein_source', 
    	'preparation_time_minutes', 'shelf_life_days', 'equipment_needed', 'origin_country', 'recipe_cuisine', 'in_your_box', 
    	'gousto_reference'
    ];

    /**
     * Scope a query to filter by params
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $params)
    {
    	return $query->select('id', 'title', 'marketing_description')->where($params);
    }
}