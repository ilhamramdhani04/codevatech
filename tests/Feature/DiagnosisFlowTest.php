<?php

namespace Tests\Feature;

use App\Models\Gejala;
use App\Models\Kategori;
use App\Models\Kerusakan;
use App\Models\Rule;
use App\Models\RuleGejala;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DiagnosisFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_diagnosis_page(): void
    {
        $response = $this->get('/diagnosis');

        $response->assertStatus(200);
        $response->assertSee('DiagnoLap');
    }

    #[DataProvider('emptySymptomSubmissions')]
    public function test_empty_diagnosis_shows_validation_alert_without_saving_history(string $role, array $payload): void
    {
        if ($role === 'teknisi') {
            $this->actingAs(User::factory()->create(['role' => 'teknisi']));
        }

        $response = $this->from('/diagnosis')->post('/diagnosis', $payload);

        $response->assertRedirect('/diagnosis')->assertSessionHasErrors('gejala_ids');
        $this->assertDatabaseCount('diagnosis_histories', 0);
        $this->get('/diagnosis')->assertOk()
            ->assertSee('showSymptomAlert("Pilih minimal satu gejala untuk melakukan diagnosis.")', false);
    }

    public static function emptySymptomSubmissions(): array
    {
        return [
            'guest without symptoms' => ['guest', []],
            'guest with empty symptoms' => ['guest', ['gejala_ids' => []]],
            'teknisi without symptoms' => ['teknisi', []],
            'teknisi with empty symptoms' => ['teknisi', ['gejala_ids' => []]],
        ];
    }

    public function test_diagnosis_process_returns_result(): void
    {
        // 1. Setup Master Data
        $kategori = Kategori::create(['nama_kategori' => 'Power & Baterai']);

        $kerusakan = Kerusakan::create([
            'kategori_id'    => $kategori->id,
            'kode_kerusakan' => 'K01',
            'nama_kerusakan' => 'Baterai Rusak / Bocor',
        ]);

        $g1 = Gejala::create(['kode_gejala' => 'G01', 'nama_gejala' => 'Laptop cepat panas']);
        $g2 = Gejala::create(['kode_gejala' => 'G02', 'nama_gejala' => 'Baterai cepat habis']);

        $rule = Rule::create([
            'kerusakan_id' => $kerusakan->id,
            'kode_rule'    => 'R01',
            'keterangan'   => 'Baterai bermasalah',
        ]);

        RuleGejala::create(['rule_id' => $rule->id, 'gejala_id' => $g1->id, 'is_negated' => false]);
        RuleGejala::create(['rule_id' => $rule->id, 'gejala_id' => $g2->id, 'is_negated' => false]);

        // 2. Submit Diagnosis with matching symptoms
        $response = $this->post('/diagnosis', [
            'nama_pengguna' => 'Ahmad Testing',
            'gejala_ids'    => [$g1->id, $g2->id],
        ]);

        $response->assertRedirect(route('diagnosis.result'));

        // 3. Verify history saved to database
        $this->assertDatabaseHas('diagnosis_histories', [
            'nama_pengguna' => 'Ahmad Testing',
        ]);
    }
}
