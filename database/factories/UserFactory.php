<?php

namespace Database\Factories;

use App\Models\Cargos;
use App\Models\Cursos;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'id_cargo' => 2,
            'id_curso' => Cursos::all()->random()->id,
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('123'),
            'matricula' => fake()->numberBetween(00000,99999),
        ];
    }
}
