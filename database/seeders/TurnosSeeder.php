<?php

namespace Database\Seeders;

use App\Models\Turnos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Turnos::factory()->create([
            'hora_entrada' => '13:00:00',
            'hora_saida' => '18:00:00',
        ]);
        Turnos::factory()->create([
            'hora_entrada' => '07:00:00',
            'hora_saida' => '15:00:00',
        ]);
        Turnos::factory()->create([
            'hora_entrada' => '05:00:00',
            'hora_saida' => '17:00:00',
        ]);

    }
}
