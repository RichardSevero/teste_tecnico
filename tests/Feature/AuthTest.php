<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'colaborador@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'colaborador@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'colaborador@example.com',
            'password' => 'password',
        ]);

        $response = $this->from('/')
            ->post('/login', [
                'email' => 'colaborador@example.com',
                'password' => 'senha-errada',
            ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }
}
