<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\FoodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rencana-makan', [MealPlanController::class, 'index'])->name('meal-plan');
Route::post('/rencana-makan', [MealPlanController::class, 'calculate'])->name('meal-plan.calculate');
Route::post('/rencana-makan/recommendations', [MealPlanController::class, 'dynamicRecommendations'])->name('meal-plan.recommendations');
Route::get('/makanan/cari', [MealPlanController::class, 'searchFood'])->name('food.search');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Route for unauthorized access redirection
Route::view('/not-allowed', 'errors.not_allowed')->name('not.allowed');

// Protected superadmin routes
Route::middleware('auth')->group(function () {
    // Dashboard accessible to all authenticated users
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    // User management & verification restricted to superadmins
    Route::middleware(\App\Http\Middleware\EnsureUserIsSuperAdmin::class)->group(function () {
        Route::get('/superadmin/users', [SuperAdminController::class, 'index'])->name('superadmin.users.index');
        Route::get('/superadmin/verification', [SuperAdminController::class, 'verification'])->name('superadmin.verification.index');
        Route::patch('/superadmin/users/{user}/approve', [SuperAdminController::class, 'approve'])->name('superadmin.users.approve');
        Route::delete('/superadmin/users/{user}/reject', [SuperAdminController::class, 'reject'])->name('superadmin.users.reject');
    });

    // Food management accessible to all authenticated users
    Route::get('/superadmin/foods', [SuperAdminController::class, 'foods'])->name('superadmin.foods.index');
    Route::get('/superadmin/foods/create', [SuperAdminController::class, 'createFood'])->name('superadmin.foods.create');
    Route::post('/superadmin/foods', [SuperAdminController::class, 'storeFood'])->name('superadmin.foods.store');
    Route::get('/superadmin/foods/{food}', [SuperAdminController::class, 'showFood'])->name('superadmin.foods.show');
    Route::get('/superadmin/foods/{food}/edit', [SuperAdminController::class, 'editFood'])->name('superadmin.foods.edit');
    Route::patch('/superadmin/foods/{food}', [SuperAdminController::class, 'updateFood'])->name('superadmin.foods.update');
    Route::patch('/superadmin/foods/{food}/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('superadmin.foods.toggle-status');
    Route::delete('/superadmin/foods/{food}', [SuperAdminController::class, 'destroyFood'])->name('superadmin.foods.destroy');
});

Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

Route::get('/debug-superadmin', function () {
    $user = \App\Models\User::where('email', 'superadmin@example.com')->first();
    if ($user) {
        return response()->json([
            'message' => 'User found. Check the password hash.',
            'user_data' => $user->toArray(),
            'is_password_correct' => Illuminate\Support\Facades\Hash::check('password', $user->password)
        ]);
    }
    return response()->json(['message' => 'Superadmin user not found.']);
});
