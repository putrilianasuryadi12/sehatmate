<?php

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ...existing code...

Route::get('/foods/search', function (Request $request) {
    $query = $request->input('query');
    $foods = Food::where('name', 'like', '%' . $query . '%')
                  ->limit(3)
                  ->get();
    return response()->json($foods);
});
