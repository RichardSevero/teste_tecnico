<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_is_admin_returns_true_for_admin_user(): void
    {
        $user = new User([
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAdmin());
    }

    public function test_is_admin_returns_false_for_collaborator(): void
    {
        $user = new User([
            'role' => 'colaborador',
        ]);

        $this->assertFalse($user->isAdmin());
    }

    public function test_has_permission_returns_true_when_user_has_permission(): void
    {
        $user = new User([
            'role' => 'colaborador',
        ]);

        $permission = new Permission([
            'name' => 'Equipamentos',
            'slug' => 'equipamentos',
            'description' => 'Acesso ao modulo de equipamentos',
        ]);

        $user->setRelation('permissions', collect([$permission]));

        $this->assertTrue($user->hasPermission('equipamentos'));
    }

    public function test_has_permission_returns_false_when_user_does_not_have_permission(): void
    {
        $user = new User([
            'role' => 'colaborador',
        ]);

        $permission = new Permission([
            'name' => 'Setores Hospitalares',
            'slug' => 'setores-hospitalares',
            'description' => 'Acesso ao modulo de setores hospitalares',
        ]);

        $user->setRelation('permissions', collect([$permission]));

        $this->assertFalse($user->hasPermission('equipamentos'));
    }
}
