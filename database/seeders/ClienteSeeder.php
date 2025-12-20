<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::insert([
            [
                'id_plan' => 1,
                'id_point' => 1,
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan@test.com',
                'direccion' => 'Calle 123',
                'telefono' => '3511111111',
                'ip' => '192.168.0.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_plan' => 2,
                'id_point' => 2,
                'nombre' => 'María',
                'apellido' => 'Gómez',
                'email' => 'maria@test.com',
                'direccion' => 'Av Siempre Viva 742',
                'telefono' => '3512222222',
                'ip' => '192.168.0.11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_plan' => 3,
                'id_point' => 1,
                'nombre' => 'Carlos',
                'apellido' => 'Lopez',
                'email' => 'carlos@test.com',
                'direccion' => 'San Martín 456',
                'telefono' => '3513333333',
                'ip' => '192.168.0.12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
