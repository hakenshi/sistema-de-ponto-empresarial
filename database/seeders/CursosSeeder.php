<?php

namespace Database\Seeders;

use App\Models\Cursos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cursos::factory()->createMany([
            ['nome' => 'Administração'],
            ['nome' => 'Ciências Contábeis'],
            ['nome' => 'Direito'],
            ['nome' => 'Educação Física (Bacharelado)'],
            ['nome' => 'Enfermagem'],
            ['nome' => 'Engenharia Civil'],
            ['nome' => 'Engenharia Elétrica'],
            ['nome' => 'Engenharia Mecânica'],
            ['nome' => 'Engenharia Química'],
            ['nome' => 'Engenharia da Computação'],
            ['nome' => 'Engenharia de Produção'],
            ['nome' => 'Engenharia de Software'],
            ['nome' => 'Farmácia'],
            ['nome' => 'Fisioterapia'],
            ['nome' => 'Jornalismo'],
            ['nome' => 'Medicina'],
            ['nome' => 'Odontologia'],
            ['nome' => 'Pedagogia'],
            ['nome' => 'Psicologia'],
            ['nome' => 'Publicidade e Propaganda'],
            ['nome' => 'Engenharia Biomédica'],
            ['nome' => 'Educação Física (Licenciatura)'],
            ['nome' => 'Comunicação e Mídias digitais'],
            ['nome' => 'Economia'],
        ]);
    }
}
