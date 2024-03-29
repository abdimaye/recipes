<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('box_type');
            $table->string('title');
            $table->string('slug');
            $table->string('short_title')->nullable();
            $table->string('marketing_description');
            $table->unsignedSmallInteger('calories_kcal');
            $table->unsignedSmallInteger('protein_grams');
            $table->unsignedSmallInteger('fat_grams');
            $table->unsignedSmallInteger('carbs_grams');
            $table->string('bulletpoint1')->nullable();
            $table->string('bulletpoint2')->nullable();
            $table->string('bulletpoint3')->nullable();
            $table->string('recipe_diet_type_id');
            $table->string('season');
            $table->string('base')->nullable();
            $table->string('protein_source');
            $table->unsignedSmallInteger('preparation_time_minutes');
            $table->unsignedSmallInteger('shelf_life_days');
            $table->string('equipment_needed');
            $table->string('origin_country');
            $table->string('recipe_cuisine');
            $table->string('in_your_box')->nullable();
            $table->unsignedInteger('gousto_reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
