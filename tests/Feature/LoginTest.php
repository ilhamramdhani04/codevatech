<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('DiagnoLap');
    }

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email'    => 'admin@diagnolap.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'email'    => 'admin@diagnolap.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_cannot_login_with_incorrect_password(): void
    {
        User::factory()->create([
            'email'    => 'admin@diagnolap.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'admin@diagnolap.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_rate_limiting_blocks_after_5_failed_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email'    => 'test@example.com',
                'password' => 'wrong',
            ]);
        }

        $response = $this->post('/admin/login', [
            'email'    => 'test@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
