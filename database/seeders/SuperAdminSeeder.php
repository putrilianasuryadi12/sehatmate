<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            'name' => 'Super Admin',
            'usia' => 30,
            'jenis_kelamin' => 'Laki-laki',
            'nomor_str' => '123456789012345',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ];

        if (Schema::hasColumn('users', 'status')) {
            $attributes['status'] = 'approved';
            $attributes['approved_at'] = now();
        }

        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            $attributes
        );
    }
}
