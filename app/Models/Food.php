<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    // Set the database table for this model
    protected $table = 'foods';

    use HasFactory;

    protected $fillable = [
        'name',
        'air_g',
        'calories',
        'protein',
        'fat',
        'carbohydrates',
        'serat_g',
        'abu_g',
        'kalsium_mg',
        'fosfor_mg',
        'besi_mg',
        'natrium_mg',
        'kalium_mg',
        'tembaga_mg',
        'seng_mg',
        'retinol_mcg',
        'b_kar_mcg',
        'kar_total_mcg',
        'thiamin_mg',
        'riboflavin_mg',
        'niasin_mg',
        'vitamin_c_mg',
        'bdd_persen',
        'urlimage',
        'status',
        'created_by',
    ];

    protected $casts = [
        'calories' => 'float',
        'protein' => 'float',
        'carbohydrates' => 'float',
        'fat' => 'float',
        'air_g' => 'float',
        'serat_g' => 'float',
        'abu_g' => 'float',
        'kalsium_mg' => 'float',
        'fosfor_mg' => 'float',
        'besi_mg' => 'float',
        'natrium_mg' => 'float',
        'kalium_mg' => 'float',
        'tembaga_mg' => 'float',
        'seng_mg' => 'float',
        'retinol_mcg' => 'float',
        'b_kar_mcg' => 'float',
        'kar_total_mcg' => 'float',
        'thiamin_mg' => 'float',
        'riboflavin_mg' => 'float',
        'niasin_mg' => 'float',
        'vitamin_c_mg' => 'float',
        'bdd_persen' => 'float',
    ];

    /**
     * Get the user who created this food.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the author name (from related user or fallback to author field).
     */
    public function getAuthorNameAttribute()
    {
        if ($this->createdBy) {
            return $this->createdBy->name;
        }
        return $this->author ?? 'Super Admin';
    }
}
