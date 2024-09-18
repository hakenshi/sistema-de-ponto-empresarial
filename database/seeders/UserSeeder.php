<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id_cargo' => 1,
            'nome' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        User::factory()->create([
            'id_cargo' => 2,
            'nome' => 'felipe',
            'email' => 'felipe@email.com',
            'password' => Hash::make('123'),
        ]);

//        User::factory(10)->create();

    }
}
