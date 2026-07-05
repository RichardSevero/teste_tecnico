<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Santa Casa',
            'email' => 'admin@santacasa.org.br',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->count(5)->create([
            'role' => 'colaborador',
        ]);

        Permission::create([
            'name' => 'Setores Hospitalares',
            'slug' => 'setores-hospitalares',
            'description' => 'Acesso ao modulo de setores hospitalares',
        ]);

        Permission::create([
            'name' => 'Especialidades Medicas',
            'slug' => 'especialidades-medicas',
            'description' => 'Acesso ao modulo de especialidades medicas',
        ]);

        Permission::create([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        Permission::create([
            'name' => 'Unidades Assistenciais',
            'slug' => 'unidades-assistenciais',
            'description' => 'Acesso ao modulo de unidades assistenciais',
        ]);
    }
}
