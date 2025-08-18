<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'usia')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('usia')->nullable();
            });
        }
        if (! Schema::hasColumn('users', 'jenis_kelamin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('jenis_kelamin')->nullable();
            });
        }
        if (! Schema::hasColumn('users', 'nomor_str')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nomor_str')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['usia', 'jenis_kelamin', 'nomor_str']);
        });
    }
};
