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

    public function test_print_diagnosis_is_unavailable_for_admin_and_teknisi(): void
    {
        foreach (['admin' => $this->admin, 'teknisi' => $this->teknisi] as $portal => $user) {
            $this->actingAs($user)
                ->get("/{$portal}/riwayat/{$this->history->id}/print")
                ->assertForbidden();
        }
    }

    public function test_csv_export_is_unavailable_for_admin_and_teknisi(): void
    {
        foreach (['admin' => $this->admin, 'teknisi' => $this->teknisi] as $portal => $user) {
            $this->actingAs($user)
                ->get("/{$portal}/riwayat/export")
                ->assertForbidden();
        }
    }

    public function test_teknisi_can_download_pdf_file_from_teknisi_portal(): void
    {
        $response = $this->actingAs($this->teknisi)->get("/teknisi/riwayat/{$this->history->id}/pdf");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertDownload('Laporan_Diagnosa_DIAG-' . str_pad($this->history->id, 5, '0', STR_PAD_LEFT) . '_Pelanggan_Test.pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_admin_cannot_download_pdf_file(): void
    {
        $this->actingAs($this->admin)
            ->get("/admin/riwayat/{$this->history->id}/pdf")
            ->assertForbidden();
    }

    public function test_guest_cannot_download_pdf_file(): void
    {
        foreach (['admin', 'teknisi'] as $portal) {
            $this->get("/{$portal}/riwayat/{$this->history->id}/pdf")
                ->assertRedirect('/admin/login');
        }
    }
}
