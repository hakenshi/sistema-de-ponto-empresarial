<?php

namespace Database\Seeders;

use App\Models\TurnosUsuarios;
use Database\Factories\TurnosUsuariosFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnosUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TurnosUsuarios::create([
            'id_turno' => 1,
            'id_usuario' => 2,
        ]);
    }
}
