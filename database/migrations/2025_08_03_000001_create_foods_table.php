<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('air_g')->nullable();
            $table->float('calories');
            $table->float('protein');
            $table->float('fat');
            $table->float('carbohydrates');
            $table->float('serat_g')->nullable();
            $table->float('abu_g')->nullable();
            $table->float('kalsium_mg')->nullable();
            $table->float('fosfor_mg')->nullable();
            $table->float('besi_mg')->nullable();
            $table->float('natrium_mg')->nullable();
            $table->float('kalium_mg')->nullable();
            $table->float('tembaga_mg')->nullable();
            $table->float('seng_mg')->nullable();
            $table->float('retinol_mcg')->nullable();
            $table->float('b_kar_mcg')->nullable();
            $table->float('kar_total_mcg')->nullable();
            $table->float('thiamin_mg')->nullable();
            $table->float('riboflavin_mg')->nullable();
            $table->float('niasin_mg')->nullable();
            $table->float('vitamin_c_mg')->nullable();
            $table->float('bdd_persen')->nullable();
            $table->string('urlimage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
}
