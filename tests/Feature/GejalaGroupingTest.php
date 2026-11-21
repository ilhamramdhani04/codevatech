<?php

namespace Tests\Feature;

use App\Models\Gejala;
use App\Models\User;
use Database\Seeders\GejalaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GejalaGroupingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_group_controls_in_list_and_forms(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $gejala = $this->symptom();

        $this->actingAs($admin)->get('/admin/gejalas')
            ->assertOk()->assertSee('Kelompok Diagnosis')->assertSee('/admin/gejalas/'.$gejala->id.'/group');
        $this->get('/admin/gejalas/create')->assertOk()->assertSee('name="diagnosis_group"', false);
        $this->get('/admin/gejalas/'.$gejala->id.'/edit')->assertOk()->assertSee('value="display" selected', false);
    }

    public function test_admin_can_create_a_grouped_and_frequent_symptom(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post('/admin/gejalas', [
                'kode_gejala' => 'G100',
                'nama_gejala' => 'Gejala layar baru',
                'diagnosis_group' => 'display',
                'is_frequent' => '1',
            ])->assertRedirect('/admin/gejalas')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('gejalas', [
            'kode_gejala' => 'G100', 'diagnosis_group' => 'display', 'is_frequent' => true,
        ]);
        $this->assertSymptomCategories('G100', 'all frequent display');
    }

    public function test_quick_group_update_preserves_frequent_status_and_logs_the_change(): void
    {
        $gejala = $this->symptom(['is_frequent' => true]);

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->from('/admin/gejalas?search=G05')
            ->patch('/admin/gejalas/'.$gejala->id.'/group', ['diagnosis_group' => 'performance'])
            ->assertRedirect('/admin/gejalas?search=G05')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('gejalas', [
            'id' => $gejala->id, 'diagnosis_group' => 'performance', 'is_frequent' => true,
            'kode_gejala' => 'G05', 'nama_gejala' => 'Layar berkedip',
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'updated', 'model_type' => Gejala::class, 'model_id' => $gejala->id,
        ]);
        // A familiar code must follow the administrator's choice, not the former mapping.
        $this->assertSymptomCategories('G05', 'all frequent performance');
    }

    public function test_full_edit_can_change_code_and_group(): void
    {
        $gejala = $this->symptom();
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->put('/admin/gejalas/'.$gejala->id, [
                'kode_gejala' => 'G101', 'nama_gejala' => 'Gejala diubah',
                'diagnosis_group' => 'input', 'is_frequent' => '1',
            ])->assertRedirect('/admin/gejalas')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('gejalas', [
            'id' => $gejala->id, 'kode_gejala' => 'G101', 'diagnosis_group' => 'input', 'is_frequent' => true,
        ]);
        $this->assertSymptomCategories('G101', 'all frequent input');
    }

    public function test_group_can_be_cleared_without_removing_frequent_status(): void
    {
        $gejala = $this->symptom(['is_frequent' => true]);
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patch('/admin/gejalas/'.$gejala->id.'/group', ['diagnosis_group' => ''])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('gejalas', ['id' => $gejala->id, 'diagnosis_group' => null, 'is_frequent' => true]);
        $this->assertSymptomCategories('G05', 'all frequent');
    }

    public function test_unknown_or_missing_groups_are_rejected_without_changing_data(): void
    {
        $gejala = $this->symptom();
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        foreach ([[], ['diagnosis_group' => 'frequent'], ['diagnosis_group' => ['display']]] as $payload) {
            $this->patch('/admin/gejalas/'.$gejala->id.'/group', $payload)
                ->assertSessionHasErrors('diagnosis_group');
        }
        $this->post('/admin/gejalas', [
            'kode_gejala' => 'G102', 'nama_gejala' => 'Tidak valid', 'diagnosis_group' => 'all',
        ])->assertSessionHasErrors('diagnosis_group');
        $this->put('/admin/gejalas/'.$gejala->id, [
            'kode_gejala' => 'G05', 'nama_gejala' => 'Tidak valid', 'diagnosis_group' => 'unknown',
        ])->assertSessionHasErrors('diagnosis_group');

        $this->assertDatabaseHas('gejalas', ['id' => $gejala->id, 'diagnosis_group' => 'display', 'nama_gejala' => 'Layar berkedip']);
        $this->assertDatabaseMissing('gejalas', ['kode_gejala' => 'G102']);
    }

    public function test_guest_and_teknisi_cannot_change_groups(): void
    {
        $gejala = $this->symptom();
        $url = '/admin/gejalas/'.$gejala->id.'/group';

        $this->patch($url, ['diagnosis_group' => 'power'])->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create(['role' => 'teknisi']))
            ->patch($url, ['diagnosis_group' => 'power'])->assertForbidden();
        $this->get('/teknisi/gejalas')->assertOk()->assertSee('Layar &amp; Tampilan', false)
            ->assertDontSee('name="diagnosis_group"', false);
        $this->patch('/teknisi/gejalas/'.$gejala->id.'/group', ['diagnosis_group' => 'power'])->assertNotFound();
        $this->assertDatabaseHas('gejalas', ['id' => $gejala->id, 'diagnosis_group' => 'display']);
    }

    public function test_frequent_toggle_keeps_the_diagnosis_group(): void
    {
        $gejala = $this->symptom();
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patch('/admin/gejalas/'.$gejala->id.'/toggle-frequent')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('gejalas', ['id' => $gejala->id, 'diagnosis_group' => 'display', 'is_frequent' => true]);
    }

    public function test_ungrouped_symptom_is_still_available_in_all_and_deleted_symptoms_are_hidden(): void
    {
        $this->symptom(['diagnosis_group' => null]);
        $deleted = $this->symptom(['kode_gejala' => 'G103', 'nama_gejala' => 'Gejala dihapus']);
        $deleted->delete();

        $this->assertSymptomCategories('G05', 'all');
        $this->get('/diagnosis')->assertDontSee('Gejala dihapus');
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patch('/admin/gejalas/'.$deleted->id.'/group', ['diagnosis_group' => 'input'])->assertNotFound();
    }

    public function test_migration_backfills_all_original_groups_without_changing_existing_symptoms(): void
    {
        $migration = require database_path('migrations/2026_11_21_000001_add_diagnosis_group_to_gejalas_table.php');
        $migration->down();
        $codes = array_map(fn ($n) => 'G'.str_pad($n, 2, '0', STR_PAD_LEFT), range(1, 66));
        $codes[] = 'G999';
        foreach ($codes as $code) {
            DB::table('gejalas')->insert([
                'kode_gejala' => $code, 'nama_gejala' => 'Data lama '.$code, 'is_frequent' => true,
                'created_at' => '2026-01-01 00:00:00', 'updated_at' => '2026-02-01 00:00:00',
                'deleted_at' => $code === 'G05' ? '2026-03-01 00:00:00' : null,
            ]);
        }
        $before = DB::table('gejalas')->orderBy('id')->get()->map(fn ($row) => (array) $row)->all();

        $migration->up();

        $after = DB::table('gejalas')->orderBy('id')->get();
        $this->assertSame($before, $after->map(function ($row) {
            $data = (array) $row;
            unset($data['diagnosis_group']);

            return $data;
        })->all());
        $this->assertSame(['display' => 6, 'input' => 16, 'performance' => 12, 'power' => 13, 'system' => 19],
            DB::table('gejalas')->whereNotNull('diagnosis_group')->get()->countBy('diagnosis_group')->sortKeys()->all());
        foreach (['G01' => 'power', 'G05' => 'display', 'G09' => 'performance', 'G21' => 'input', 'G31' => 'system', 'G999' => null] as $code => $group) {
            $this->assertDatabaseHas('gejalas', ['kode_gejala' => $code, 'diagnosis_group' => $group]);
        }
    }

    public function test_fresh_seed_assigns_the_same_groups_as_the_upgrade_migration(): void
    {
        $this->seed(GejalaSeeder::class);
        $before = Gejala::orderBy('id')->pluck('diagnosis_group', 'kode_gejala')->all();
        $this->assertCount(66, $before);
        $this->assertNotContains(null, $before);
        $migration = require database_path('migrations/2026_11_21_000001_add_diagnosis_group_to_gejalas_table.php');
        $migration->down();
        $migration->up();

        $this->assertSame($before, Gejala::orderBy('id')->pluck('diagnosis_group', 'kode_gejala')->all());
    }

    private function symptom(array $attributes = []): Gejala
    {
        return Gejala::create(array_merge([
            'kode_gejala' => 'G05', 'nama_gejala' => 'Layar berkedip',
            'diagnosis_group' => 'display', 'is_frequent' => false,
        ], $attributes));
    }

    private function assertSymptomCategories(string $code, string $categories): void
    {
        // Drop any admin test authentication before opening the guest diagnosis page.
        auth()->forgetGuards();
        $response = $this->get('/diagnosis')->assertOk();
        $this->assertMatchesRegularExpression(
            '/data-categories="'.preg_quote($categories, '/').'"[^>]*>\s*<input[^>]+>\s*<div>\s*<span class="gejala-code">'.preg_quote($code, '/').'<\/span>/s',
            $response->getContent(),
        );
    }
}
