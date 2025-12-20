<?php

namespace Database\Seeders;

use App\Models\Access_Point;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Access_Point::insert([
            [
                'ssid' => 'AP-Centro',
                'frecuencia' => '5GHz',
                'ip_ap' => '192.168.1.1',
                'localidad' => 'Centro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ssid' => 'AP-Barrio-Norte',
                'frecuencia' => '2.4GHz',
                'ip_ap' => '192.168.1.2',
                'localidad' => 'Barrio Norte',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
