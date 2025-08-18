<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealPlanController extends Controller
{
    public function index()
    {
        $foods = DB::table('foods')->orderBy('name')->get();
        return view('meal-plan', ['foods' => $foods]);
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:1',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'weight' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'breakfast' => 'nullable|integer|exists:foods,id',
            'lunch' => 'nullable|integer|exists:foods,id',
            'dinner' => 'nullable|integer|exists:foods,id',
        ]);

        // Ambil data makanan
        $breakfastFood = $validated['breakfast'] ? DB::table('foods')->find($validated['breakfast']) : null;
        $lunchFood = $validated['lunch'] ? DB::table('foods')->find($validated['lunch']) : null;
        $dinnerFood = $validated['dinner'] ? DB::table('foods')->find($validated['dinner']) : null;

        // Tentukan grup usia dan ambil kebutuhan nutrisi
        $age = $validated['age'];
        $gender = $validated['gender'];
        $ageGroup = $this->getAgeGroup($age, $gender);
        $requirements = DB::table('nutritional_requirements')
            ->where('gender', $gender)
            ->where('age_group', $ageGroup)
            ->first();

        // Hitung total intake, termasuk vitamin C dan zat besi
        $totalIntake = [
            'calories' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'vitamin_c' => 0,
            'besi_mg' => 0,
            'seng_mg' => 0, // zinc
        ];
        foreach ([$breakfastFood, $lunchFood, $dinnerFood] as $food) {
            if ($food) {
                $totalIntake['calories'] += $food->calories;
                $totalIntake['protein'] += $food->protein;
                $totalIntake['fat'] += $food->fat;
                $totalIntake['carbohydrates'] += $food->carbohydrates;
                $totalIntake['vitamin_c'] += $food->vitamin_c_mg ?? 0;
                $totalIntake['besi_mg'] += $food->besi_mg ?? 0;
                $totalIntake['seng_mg'] += $food->seng_mg ?? 0; // zinc
            }
        }

        // Konfigurasi nutrisi
        $nutrientConfig = [
            'calories' => ['column' => 'calories', 'requirement' => 'energi_kkal'],
            'protein' => ['column' => 'protein', 'requirement' => 'protein_g'],
            'carbohydrates' => ['column' => 'carbohydrates', 'requirement' => 'karbohidrat_g'],
            'fat' => ['column' => 'fat', 'requirement' => 'lemak_total_g'],
            'vitamin_c' => ['column' => 'vitamin_c_mg', 'requirement' => 'vitamin_c_mg'],
            'besi_mg' => ['column' => 'besi_mg', 'requirement' => 'besi_mg'],
            'seng_mg' => ['column' => 'seng_mg', 'requirement' => 'seng_mg'], // zinc
        ];

        // Hitung kebutuhan dan defisit
        $deficits = [];
        $percentages = [];
        foreach ($nutrientConfig as $key => $cfg) {
            $req = $requirements->{$cfg['requirement']} ?? 0;
            $cur = $totalIntake[$key] ?? 0;
            $percentages[$key] = $req > 0 ? ($cur / $req) * 100 : 0;
            $deficits[$key] = max(0, $req - $cur);
        }

        // Determine nutrient with lowest fulfillment percentage (focus)
        $focusNutrient = collect($percentages)->filter(function($val, $key) use ($nutrientConfig) {
            return array_key_exists($key, $nutrientConfig);
        })->sort()->keys()->first();

        // Exclude foods already chosen
        $excludedIds = array_filter([
            $validated['breakfast'] ?? null,
            $validated['lunch'] ?? null,
            $validated['dinner'] ?? null,
        ]);

        // Cari rekomendasi makanan per nutrisi berdasarkan defisit
        $recommendationsByNutrient = [];
        foreach ($deficits as $key => $def) {
            if ($def > 0) {
                $col = $nutrientConfig[$key]['column'];
                $reqVal = $requirements->{$nutrientConfig[$key]['requirement']} ?? 0;
                $query = DB::table('foods');
                if (!empty($excludedIds)) {
                    $query->whereNotIn('id', $excludedIds);
                }
                // Recommend foods that best cover the deficit as a percentage of total requirement
                $recommendationsByNutrient[$key] = $query
                    ->where($col, '<=', $def)
                    ->orderByRaw("($col / ?) desc", [$reqVal])
                    ->limit(3)
                    ->get();
            } else {
                $recommendationsByNutrient[$key] = collect();
            }
        }

        // Filter recommendations to only focus nutrient
        if ($focusNutrient && isset($recommendationsByNutrient[$focusNutrient])) {
            $recommendationsByNutrient = [ $focusNutrient => $recommendationsByNutrient[$focusNutrient] ];
        }

        // Combined recommendations: foods that boost multiple deficits without exceeding any requirement
        $boostCandidates = [];
        $foodsAll = DB::table('foods')
            ->whereNotIn('id', $excludedIds)
            ->get();
        foreach ($foodsAll as $food) {
            $valid = true;
            $score = 0;
            foreach ($deficits as $key => $def) {
                if ($def <= 0) continue;
                $col = $nutrientConfig[$key]['column'];
                $val = $food->{$col} ?? 0;
                // skip if overshoot
                if ($val > $def) { $valid = false; break; }
                $score += $def > 0 ? ($val / $def) : 0;
            }
            if ($valid && $score > 0) { $food->score = $score; $boostCandidates[] = $food; }
        }
        usort($boostCandidates, fn($a, $b) => $b->score <=> $a->score);
        $combinedRecommendations = array_slice($boostCandidates, 0, 3);

        // Ensure recommendationsPerMeal exists
        $recommendationsPerMeal = [];

         // Data untuk view
         return view('meal-plan', [
             'requirements' => $requirements,
             'totalIntake' => $totalIntake,
             'meals' => ['breakfast' => $breakfastFood, 'lunch' => $lunchFood, 'dinner' => $dinnerFood],
             'nutrientConfig' => $nutrientConfig,
             'percentages' => $percentages,
             'recommendationsByNutrient' => $recommendationsByNutrient,
             'focusNutrient' => $focusNutrient,
             'combinedRecommendations' => $combinedRecommendations,
             'recommendationsPerMeal' => $recommendationsPerMeal,
         ]);
    }

    /**
     * Return new recommendations based on current selected meals via AJAX.
     */
    public function dynamicRecommendations(Request $request)
    {
        $data = $request->validate([
            'breakfast' => 'nullable|array',
            'breakfast.*' => 'integer|exists:foods,id',
            'lunch' => 'nullable|array',
            'lunch.*' => 'integer|exists:foods,id',
            'dinner' => 'nullable|array',
            'dinner.*' => 'integer|exists:foods,id',
        ]);

        // Fetch selected foods
        $selectedIds = array_merge(
            $data['breakfast'] ?? [],
            $data['lunch'] ?? [],
            $data['dinner'] ?? []
        );
        $foods = DB::table('foods')->whereIn('id', $selectedIds)->get();

        // Get requirements for the user from request or session (assumes stored in session)
        $requirements = session('meal_plan_requirements');
        if (!$requirements) {
            return response()->json(['error' => 'Nutritional requirements not found.'], 400);
        }

        // Compute totalIntake
        $totalIntake = ['calories'=>0,'protein'=>0,'fat'=>0,'carbohydrates'=>0,'vitamin_c'=>0,'besi_mg'=>0,'seng_mg'=>0];
        foreach ($foods as $food) {
            $totalIntake['calories'] += $food->calories;
            $totalIntake['protein'] += $food->protein;
            $totalIntake['fat'] += $food->fat;
            $totalIntake['carbohydrates'] += $food->carbohydrates;
            $totalIntake['vitamin_c'] += $food->vitamin_c_mg ?? 0;
            $totalIntake['besi_mg'] += $food->besi_mg ?? 0;
            $totalIntake['seng_mg'] += $food->seng_mg ?? 0;
        }

        // Nutrient configuration (same as calculate)
        $nutrientConfig = [
            'calories'=>['column'=>'calories','requirement'=>'energi_kkal'],
            'protein'=>['column'=>'protein','requirement'=>'protein_g'],
            'carbohydrates'=>['column'=>'carbohydrates','requirement'=>'karbohidrat_g'],
            'fat'=>['column'=>'fat','requirement'=>'lemak_total_g'],
            'vitamin_c'=>['column'=>'vitamin_c_mg','requirement'=>'vitamin_c_mg'],
            'besi_mg'=>['column'=>'besi_mg','requirement'=>'besi_mg'],
            'seng_mg'=>['column'=>'seng_mg','requirement'=>'seng_mg'],
        ];

        // Compute deficits and percentages
        $deficits=[]; $percentages=[];
        foreach ($nutrientConfig as $key=>$cfg) {
            $reqVal = $requirements->{$cfg['requirement']} ?? 0;
            $curVal = $totalIntake[$key] ?? 0;
            $percentages[$key] = $reqVal>0 ? ($curVal/$reqVal)*100 : 0;
            $deficits[$key] = max(0, $reqVal - $curVal);
        }

        // Instead of single nutrient focus, compute multi-nutrient boosting score
        $candidateQuery = DB::table('foods');
        if (!empty($selectedIds)) {
            $candidateQuery->whereNotIn('id', $selectedIds);
        }
        $candidates = $candidateQuery->get();

        $boosts = [];
        foreach ($candidates as $food) {
            $valid = true;
            $score = 0;
            foreach ($percentages as $nutrient => $perc) {
                if ($perc >= 100) {
                    continue; // skip nutrients already fulfilled
                }
                if (!isset($nutrientConfig[$nutrient])) {
                    continue;
                }
                $col = $nutrientConfig[$nutrient]['column'];
                $defVal = $deficits[$nutrient] ?? 0;
                if ($defVal <= 0) {
                    continue;
                }
                $val = $food->{$col} ?? 0;
                // skip if food overshoots deficit for this nutrient
                if ($val > $defVal) {
                    $valid = false;
                    break;
                }
                // contribution normalized to requirement
                $reqVal = $requirements->{$nutrientConfig[$nutrient]['requirement']} ?? 1;
                $score += ($val / $reqVal);
            }
            if ($valid && $score > 0) {
                $food->score = $score;
                $boosts[] = $food;
            }
        }
        // sort by score desc and take top 3
        usort($boosts, fn($a, $b) => $b->score <=> $a->score);
        $recommendations = array_slice($boosts, 0, 3);

        return response()->json([
            'recommendations' => $recommendations,
            'percentages' => $percentages,
            'deficits' => $deficits,
        ]);
    }

    private function getAgeGroup($age, $gender)
    {
        if ($gender == 'Laki-laki') {
            if ($age >= 13 && $age <= 15) return '13-15 tahun';
            if ($age >= 16 && $age <= 18) return '16-18 tahun';
            if ($age >= 19 && $age <= 29) return '19-29 tahun';
            if ($age >= 30 && $age <= 49) return '30-49 tahun';
            if ($age >= 50 && $age <= 64) return '50-64 tahun';
            if ($age >= 65 && $age <= 80) return '65-80 tahun';
            if ($age > 80) return '80+ tahun';
        } else { // Perempuan
            if ($age >= 13 && $age <= 15) return '13-15 tahun';
            if ($age >= 16 && $age <= 18) return '16-18 tahun';
            if ($age >= 19 && $age <= 29) return '19-29 tahun';
            if ($age >= 30 && $age <= 49) return '30-49 tahun';
            if ($age >= 50 && $age <= 64) return '50-64 tahun';
            if ($age >= 65 && $age <= 80) return '65-80 tahun';
            if ($age > 80) return '80+ tahun';
        }
        return '19-29 tahun'; // Default
    }

    private function calculateTotalIntake($foods)
    {
        $total = [
            'calories' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
        ];

        foreach ($foods as $food) {
            if ($food) {
                $total['calories'] += $food->calories;
                $total['protein'] += $food->protein;
                $total['fat'] += $food->fat;
                $total['carbohydrates'] += $food->carbohydrates;
            }
        }

        return $total;
    }

    public function searchFood(Request $request)
    {
        $query = $request->get('query');
        if ($query) {
            $data = DB::table('foods')
                ->where('name', 'LIKE', "%{$query}%")
                ->get();
            return response()->json($data);
        }
        return response()->json([]);
    }
}
