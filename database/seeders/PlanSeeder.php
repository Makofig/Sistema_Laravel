<?php

namespace Database\Seeders;

use App\Models\Contracts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contracts::insert([
            [
                'nombre' => 'Plan 50MB',
                'megabytes' => 50,
                'costo' => 8000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Plan 100MB',
                'megabytes' => 100,
                'costo' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Plan 300MB',
                'megabytes' => 300,
                'costo' => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
