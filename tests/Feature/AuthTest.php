<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_see_manage_buttons_on_home(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('Nieuw project');
    }

    public function test_admin_can_login_with_email_and_password(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('messages.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_when_creating_project(): void
    {
        $response = $this->get('/projects/create');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_see_manage_buttons_on_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertSee('Nieuw project');
    }
}
