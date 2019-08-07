<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    if (($handle = fopen ( database_path('seeds/recipe-data.csv'), 'r' )) !== FALSE) {

	    	$firstRow = true;

	        while ( ($data = fgetcsv ( $handle )) !== FALSE ) {

	        	if ($firstRow) { $firstRow = false; continue; }

	        	DB::table('recipes')->insert([
	        		'id' => $data[0],
	        		'created_at' => Carbon::createFromFormat('d/m/Y H:i:s', $data[1]),
	        		'updated_at' => Carbon::createFromFormat('d/m/Y H:i:s', $data[2]),
			        'box_type' => $data[3],
			        'title' => $data[4],
			        'slug' => $data[5],
			        'short_title' => $data[6],
			        'marketing_description' => $data[7],
			        'calories_kcal' => $data[8],
			        'protein_grams' => $data[9],
			        'fat_grams' => $data[10],
			        'carbs_grams' => $data[11],
			        'bulletpoint1' => $data[12],
			        'bulletpoint2' => $data[13],
			        'bulletpoint3' => $data[14],
			        'recipe_diet_type_id' => $data[15],
			        'season' => $data[16],
			        'base' => $data[17],
			        'protein_source' => $data[18],
			        'preparation_time_minutes' => $data[19],
			        'shelf_life_days' => $data[20],
			        'equipment_needed' => $data[21],
			        'origin_country' => $data[22],
			        'recipe_cuisine' => $data[23],
			        'in_your_box' => $data[24],
			        'gousto_reference' => $data[25]
	        	]);
	        }

	        fclose ( $handle );
	    }
    }
}
