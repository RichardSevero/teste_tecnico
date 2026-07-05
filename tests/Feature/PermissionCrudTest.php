<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_permission(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->post(route('permissions.store'), [
                'name' => 'Setores Hospitalares',
                'slug' => 'setores-hospitalares',
                'description' => 'Acesso ao modulo de setores hospitalares',
            ]);

        $response->assertRedirect(route('permissions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permissions', [
            'name' => 'Setores Hospitalares',
            'slug' => 'setores-hospitalares',
        ]);
    }

    public function test_admin_can_update_permission(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $permission = Permission::create([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('permissions.update', $permission), [
                'name' => 'Equipamentos Medicos',
                'slug' => 'equipamentos-medicos',
                'description' => 'Acesso atualizado ao modulo de equipamentos',
            ]);

        $response->assertRedirect(route('permissions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'Equipamentos Medicos',
            'slug' => 'equipamentos-medicos',
        ]);
    }

    public function test_admin_can_delete_permission_without_linked_users(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $permission = Permission::create([
            'name' => 'Especialidades Medicas',
            'slug' => 'especialidades-medicas',
            'description' => 'Acesso ao modulo de especialidades medicas',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('permissions.destroy', $permission));

        $response->assertRedirect(route('permissions.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('permissions', [
            'id' => $permission->id,
        ]);
    }
}
