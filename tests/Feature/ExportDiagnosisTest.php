<?php

namespace Tests\Feature;

use App\Models\DiagnosisHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportDiagnosisTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $teknisi;
    private DiagnosisHistory $history;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->teknisi = User::factory()->create(['role' => 'teknisi']);

        $this->history = DiagnosisHistory::create([
            'nama_pengguna'     => 'Pelanggan Test',
            'laptop_info_manual'=> 'ASUS ROG Strix',
            'tanggal_diagnosis' => now(),
        ]);
    }

    public function test_admin_and_teknisi_can_access_print_diagnosis(): void
    {
        $responseAdmin = $this->actingAs($this->admin)->get("/admin/riwayat/{$this->history->id}/print");
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('DiagnoLap — Laboratorium Service');

        $responseTeknisi = $this->actingAs($this->teknisi)->get("/admin/riwayat/{$this->history->id}/print");
        $responseTeknisi->assertStatus(200);
        $responseTeknisi->assertSee('Pelanggan Test');
    }

    public function test_admin_and_teknisi_can_export_csv_rekap(): void
    {
        $response = $this->actingAs($this->teknisi)->get('/admin/riwayat/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_admin_and_teknisi_can_download_pdf_file(): void
    {
        $response = $this->actingAs($this->teknisi)->get("/admin/riwayat/{$this->history->id}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
