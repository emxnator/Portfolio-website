<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_submit_the_contact_form(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to invite you for an interview.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }

    public function test_contact_form_requires_valid_input(): void
    {
        $response = $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_logged_in_admin_cannot_submit_the_contact_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/contact', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to invite you for an interview.',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_section_is_hidden_for_logged_in_admin(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertDontSee('Neem contact op');
    }

    public function test_guest_cannot_view_messages_inbox(): void
    {
        $response = $this->get('/messages');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_submitted_messages(): void
    {
        $user = User::factory()->create();
        ContactMessage::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'I would like to invite you for an interview.',
        ]);

        $response = $this->actingAs($user)->get('/messages');

        $response->assertOk();
        $response->assertSee('Jane Doe');
    }
}
