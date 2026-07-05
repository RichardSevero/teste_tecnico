<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_administrative_screens(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('permissions.index'))
            ->assertOk();
    }

    public function test_collaborator_cannot_access_administrative_screens(): void
    {
        $collaborator = User::factory()->create([
            'role' => 'colaborador',
        ]);

        $this->actingAs($collaborator)
            ->get(route('users.index'))
            ->assertForbidden();

        $this->actingAs($collaborator)
            ->get(route('permissions.index'))
            ->assertForbidden();
    }

    public function test_collaborator_can_access_only_allowed_module(): void
    {
        $collaborator = User::factory()->create([
            'role' => 'colaborador',
        ]);

        $allowedPermission = Permission::create([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        $blockedPermission = Permission::create([
            'name' => 'Setores Hospitalares',
            'slug' => 'setores-hospitalares',
            'description' => 'Acesso ao modulo de setores hospitalares',
        ]);

        $collaborator->permissions()->attach($allowedPermission->id);

        $this->actingAs($collaborator)
            ->get(route('modules.show', $allowedPermission))
            ->assertOk();

        $this->actingAs($collaborator)
            ->get(route('modules.show', $blockedPermission))
            ->assertForbidden();
    }

    public function test_admin_cannot_access_operational_modules(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $permission = Permission::create([
            'name' => 'Unidades Assistenciais',
            'slug' => 'unidades-assistenciais',
            'description' => 'Acesso ao modulo de unidades assistenciais',
        ]);

        $this->actingAs($admin)
            ->get(route('modules.show', $permission))
            ->assertForbidden();
    }

    public function test_permission_with_linked_users_cannot_be_deleted(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $collaborator = User::factory()->create([
            'role' => 'colaborador',
        ]);

        $permission = Permission::create([
            'name' => 'Especialidades Medicas',
            'slug' => 'especialidades-medicas',
            'description' => 'Acesso ao modulo de especialidades medicas',
        ]);

        $collaborator->permissions()->attach($permission->id);

        $response = $this->actingAs($admin)
            ->delete(route('permissions.destroy', $permission));

        $response->assertRedirect(route('permissions.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
        ]);
    }
}
