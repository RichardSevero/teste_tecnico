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

        $setores = Permission::create([
            'name' => 'Setores Hospitalares',
            'slug' => 'setores-hospitalares',
            'description' => 'Acesso ao modulo de setores hospitalares',
        ]);

        $especialidades = Permission::create([
            'name' => 'Especialidades Medicas',
            'slug' => 'especialidades-medicas',
            'description' => 'Acesso ao modulo de especialidades medicas',
        ]);

        $equipamentos = Permission::create([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        $unidades = Permission::create([
            'name' => 'Unidades Assistenciais',
            'slug' => 'unidades-assistenciais',
            'description' => 'Acesso ao modulo de unidades assistenciais',
        ]);

        $colaborador = User::factory()->create([
            'name' => 'Colaborador Teste',
            'email' => 'colaborador@santacasa.org.br',
            'password' => bcrypt('password'),
            'role' => 'colaborador',
        ]);

        $colaborador->permissions()->attach([
            $unidades->id,
            $equipamentos->id,
        ]);

        User::factory()->count(13)->create([
            'role' => 'colaborador',
        ]);
    }
}
