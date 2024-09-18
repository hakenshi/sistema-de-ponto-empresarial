<?php

namespace Database\Seeders;

use App\Models\Pontos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PontosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pontos::factory()->count(100)->create();
    }
}
