<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionalRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nutritional_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->string('age_group');
            $table->float('bb_kg')->nullable();
            $table->float('tb_cm')->nullable();
            $table->float('energi_kkal')->nullable();
            $table->float('protein_g')->nullable();
            $table->float('lemak_total_g')->nullable();
            $table->float('lemak_n6_g')->nullable();
            $table->float('lemak_n3_g')->nullable();
            $table->float('karbohidrat_g')->nullable();
            $table->float('serat_g')->nullable();
            $table->float('air_ml')->nullable();
            $table->float('vitamin_a_mcg')->nullable();
            $table->float('vitamin_c_mg')->nullable();
            $table->float('kalsium_mg')->nullable();
            $table->float('fosfor_mg')->nullable();
            $table->float('magnesium_mg')->nullable();
            $table->float('natrium_mg')->nullable();
            $table->float('kalium_mg')->nullable();
            $table->float('mangan_mg')->nullable();
            $table->float('tembaga_mcg')->nullable();
            $table->float('kromium_mcg')->nullable();
            $table->float('besi_mg')->nullable();
            $table->float('iodium_mcg')->nullable();
            $table->float('seng_mg')->nullable();
            $table->float('selenium_mcg')->nullable();
            $table->float('flour_mg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritional_requirements');
    }
}
