<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $teknisi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'role'  => 'admin',
        ]);

        $this->teknisi = User::factory()->create([
            'email' => 'teknisi@test.com',
            'role'  => 'teknisi',
        ]);
    }

    public function test_super_admin_can_access_user_management_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Kelola User');
    }

    public function test_teknisi_cannot_access_user_management_page(): void
    {
        $response = $this->actingAs($this->teknisi)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_teknisi_can_access_admin_dashboard_and_riwayat(): void
    {
        $response = $this->actingAs($this->teknisi)->get('/admin');
        $response->assertStatus(200);

        $responseRiwayat = $this->actingAs($this->teknisi)->get('/admin/riwayat');
        $responseRiwayat->assertStatus(200);
    }

    public function test_super_admin_can_create_new_teknisi_user(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'name'                  => 'Budi Teknisi Baru',
            'email'                 => 'buditeknisi@diagnolap.com',
            'role'                  => 'teknisi',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/admin/users');

        $this->assertDatabaseHas('users', [
            'email' => 'buditeknisi@diagnolap.com',
            'role'  => 'teknisi',
        ]);

        // Audit Log verification
        $this->assertDatabaseHas('activity_logs', [
            'action'     => 'created',
            'model_type' => User::class,
        ]);
    }

    public function test_super_admin_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->admin)
                         ->from('/admin/users')
                         ->delete("/admin/users/{$this->admin->id}");

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
        ]);
    }
}
