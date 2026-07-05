<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_collaborator_with_permissions(): void
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
            ->post(route('users.store'), [
                'name' => 'Carlos Silva',
                'email' => 'carlos@example.com',
                'password' => 'password',
                'role' => 'colaborador',
                'permissions' => [$permission->id],
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'name' => 'Carlos Silva',
            'email' => 'carlos@example.com',
            'role' => 'colaborador',
        ]);

        $user = User::where('email', 'carlos@example.com')->firstOrFail();
        $this->assertTrue($user->permissions->contains('id', $permission->id));
    }

    public function test_admin_can_update_user_and_sync_permissions(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $oldPermission = Permission::create([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        $newPermission = Permission::create([
            'name' => 'Unidades Assistenciais',
            'slug' => 'unidades-assistenciais',
            'description' => 'Acesso ao modulo de unidades assistenciais',
        ]);

        $user = User::factory()->create([
            'name' => 'Carlos Silva',
            'email' => 'carlos@example.com',
            'role' => 'colaborador',
        ]);

        $user->permissions()->attach($oldPermission->id);

        $response = $this->actingAs($admin)
            ->put(route('users.update', $user), [
                'name' => 'Carlos Souza',
                'email' => 'carlos.souza@example.com',
                'password' => '',
                'role' => 'colaborador',
                'permissions' => [$newPermission->id],
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('Carlos Souza', $user->name);
        $this->assertSame('carlos.souza@example.com', $user->email);
        $this->assertTrue($user->permissions->contains('id', $newPermission->id));
        $this->assertFalse($user->permissions->contains('id', $oldPermission->id));
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'role' => 'colaborador',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
