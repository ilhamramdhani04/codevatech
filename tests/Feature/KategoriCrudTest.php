<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_kategori_list(): void
    {
        Kategori::create(['nama_kategori' => 'Hardware']);

        $response = $this->actingAs($this->admin)->get('/admin/kategoris');

        $response->assertStatus(200);
        $response->assertSee('Hardware');
    }

    public function test_admin_can_create_new_kategori(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kategoris', [
            'nama_kategori' => 'Layar & Display',
        ]);

        $response->assertRedirect('/admin/kategoris');
        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Layar & Display',
        ]);

        // Verify audit log entry
        $this->assertDatabaseHas('activity_logs', [
            'action'     => 'created',
            'model_type' => Kategori::class,
        ]);
    }

    public function test_kategori_validation_requires_unique_name(): void
    {
        Kategori::create(['nama_kategori' => 'Baterai']);

        $response = $this->actingAs($this->admin)
                         ->from('/admin/kategoris/create')
                         ->post('/admin/kategoris', [
                             'nama_kategori' => 'Baterai',
                         ]);

        $response->assertRedirect('/admin/kategoris/create');
        $response->assertSessionHasErrors('nama_kategori');
    }
}
