<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class NutritionalRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('Perhitungan Gizi (usia).csv');
        if (!file_exists($file) || !($handle = fopen($file, 'r'))) {
            return;
        }
        $header = fgetcsv($handle);
        $header = array_map('trim', $header);
        $currentGender = null;
        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[0]) && count(array_filter($row)) == 0) continue;
            if (stripos($row[0], 'Laki-laki') !== false) {
                $currentGender = 'Laki-laki';
                continue;
            }
            if (stripos($row[0], 'Perempuan') !== false) {
                $currentGender = 'Perempuan';
                continue;
            }
            if (preg_match('/^\d/', $row[0]) && $currentGender) {
                DB::table('nutritional_requirements')->insert([
                    'gender' => $currentGender,
                    'age_group' => $row[0],
                    'bb_kg' => $row[1] ?? null,
                    'tb_cm' => $row[2] ?? null,
                    'energi_kkal' => $row[3] ?? null,
                    'protein_g' => $row[4] ?? null,
                    'lemak_total_g' => $row[5] ?? null,
                    'lemak_n6_g' => $row[6] ?? null,
                    'lemak_n3_g' => $row[7] ?? null,
                    'karbohidrat_g' => $row[8] ?? null,
                    'serat_g' => $row[9] ?? null,
                    'air_ml' => $row[10] ?? null,
                    'vitamin_a_mcg' => $row[11] ?? null,
                    'vitamin_c_mg' => $row[12] ?? null,
                    'kalsium_mg' => $row[13] ?? null,
                    'fosfor_mg' => $row[14] ?? null,
                    'magnesium_mg' => $row[15] ?? null,
                    'natrium_mg' => $row[16] ?? null,
                    'kalium_mg' => $row[17] ?? null,
                    'mangan_mg' => $row[18] ?? null,
                    'tembaga_mcg' => $row[19] ?? null,
                    'kromium_mcg' => $row[20] ?? null,
                    'besi_mg' => $row[21] ?? null,
                    'iodium_mcg' => $row[22] ?? null,
                    'seng_mg' => $row[23] ?? null,
                    'selenium_mcg' => $row[24] ?? null,
                    'flour_mg' => $row[25] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        fclose($handle);
    }
}
