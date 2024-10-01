<?php

namespace Database\Seeders;

use App\Models\Cargos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargos::factory()->create([
            'nome' => 'admin'
        ]);

        Cargos::factory()->create([
            'nome' => 'embaixador'
        ]);
    }
}
