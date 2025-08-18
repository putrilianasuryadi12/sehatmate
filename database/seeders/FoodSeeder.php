<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;
use Illuminate\Support\Facades\File;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('Perhitungan Gizi Cleared.csv');
        if (!file_exists($file) || !($handle = fopen($file, 'r'))) {
            return;
        }
        // Read header and trim
        $header = fgetcsv($handle);
        $header = array_map('trim', $header);
        // Process rows with proper CSV parsing (handles multiline quoted fields)
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($header)) {
                continue;
            }
            $foodData = array_combine($header, $row);
            // Skip rows with non-numeric air values
            if (!isset($foodData['Air (g)']) || !is_numeric($foodData['Air (g)'])) {
                continue;
            }
            Food::create([
                'name' => $foodData['NAMA BAHAN'],
                'air_g' => (float) $foodData['Air (g)'],
                'calories' => (float) $foodData['Energi (kal)'],
                'protein' => (float) $foodData['Protein (g)'],
                'fat' => (float) $foodData['Lemak (g)'],
                'carbohydrates' => (float) $foodData['Karbohidrat (g)'],
                'serat_g' => is_numeric($foodData['Serat (g)']) ? (float) $foodData['Serat (g)'] : null,
                'abu_g' => is_numeric($foodData['Abu (g)']) ? (float) $foodData['Abu (g)'] : null,
                'kalsium_mg' => is_numeric($foodData['Kalsium (mg)']) ? (float) $foodData['Kalsium (mg)'] : null,
                'fosfor_mg' => is_numeric($foodData['Fosfor (mg)']) ? (float) $foodData['Fosfor (mg)'] : null,
                'besi_mg' => is_numeric($foodData['Besi (mg)']) ? (float) $foodData['Besi (mg)'] : null,
                'natrium_mg' => is_numeric($foodData['Natrium (mg)']) ? (float) $foodData['Natrium (mg)'] : null,
                'kalium_mg' => is_numeric($foodData['Kalium (mg)']) ? (float) $foodData['Kalium (mg)'] : null,
                'tembaga_mg' => is_numeric($foodData['Tembaga (mg)']) ? (float) $foodData['Tembaga (mg)'] : null,
                'seng_mg' => is_numeric($foodData['Seng (mg)']) ? (float) $foodData['Seng (mg)'] : null,
                'retinol_mcg' => is_numeric($foodData['Retinol (mcg)']) ? (float) $foodData['Retinol (mcg)'] : null,
                'b_kar_mcg' => is_numeric($foodData['B-Kar (mcg)']) ? (float) $foodData['B-Kar (mcg)'] : null,
                'kar_total_mcg' => is_numeric($foodData['Kar-Total (mcg)']) ? (float) $foodData['Kar-Total (mcg)'] : null,
                'thiamin_mg' => is_numeric($foodData['Thiamin (mg)']) ? (float) $foodData['Thiamin (mg)'] : null,
                'riboflavin_mg' => is_numeric($foodData['Riboflavin (mg)']) ? (float) $foodData['Riboflavin (mg)'] : null,
                'niasin_mg' => is_numeric($foodData['Niasin (mg)']) ? (float) $foodData['Niasin (mg)'] : null,
                'vitamin_c_mg' => is_numeric($foodData['Vitamin C']) ? (float) $foodData['Vitamin C'] : null,
                'bdd_persen' => is_numeric($foodData['BDD (%)']) ? (float) $foodData['BDD (%)'] : null,
                'urlimage' => null
            ]);
        }
        fclose($handle);
    }
}
