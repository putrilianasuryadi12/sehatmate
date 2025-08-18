<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed a super admin account
        $this->call(SuperAdminSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(NutritionalRequirementSeeder::class);
    }
}
