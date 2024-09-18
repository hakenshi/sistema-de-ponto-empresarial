<?php

namespace Database\Factories;

use App\Models\Turnos;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TurnosUsuarios>
 */
class TurnosUsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => User::all()->random()->id,
            'id_turno' => Turnos::all()->random()->id,
        ];
    }
}
